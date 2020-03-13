<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Mail\UserRegistered;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Mail;
use Storage;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:update-user,user')->only(['edit', 'update']);
        $this->middleware('can:manage')->only(['create', 'store']);
        $this->middleware('can:destroy-user,user')->only('destroy');
    }

    /**
     * View all users
     */
    public function index($message_type = null, $message = null)
    {
        $users = resolveProfilePics(User::orderBy('id', 'ASC')->paginate(20));

        if (strlen($message_type) > 0) {
            return view('users.index', ['users' => $users, $message_type => $message]);
        }
        return view('users.index', compact('users'));
    }

    /**
     * Put a user in the trash
     */
    public function destroy(User $user)
    {
        // Remove profile picture
        if ($user->getOriginal('profile_picture') !== null) {
            Storage::disk('public')->delete($user->getOriginal('profile_picture'));
        }

        $user->delete();

        // Send users that delete their own account back to the homepage
        if ($user->id === Auth::user()->id) {
            return redirect()->route('index')->with('success', 'Uw account is verwijderd');
        }

        return redirect()->route('users.index')->with('success', 'Gebruiker verwijderd');
    }

    /**
     * View to edit a user
     */
    public function edit(User $user)
    {
        // Add placeholder image if there is no profile picture
        $user = resolveProfilePic($user);
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        // Validate request
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255|string',
            'password' => 'nullable|min:8|string',
            'old_password' => 'nullable|min:8|string',
            'description' => 'nullable|string',
            'profile_picture' => 'nullable|image',
            'role' => 'nullable|in:member,admin',
        ]);

        // Name
        if (isset($validatedData['name']) && $validatedData['name'] !== null) {
            // Only change when request comes from admin
            if (Gate::allows('manage')) {
                $user->name = $validatedData['name'];
            } else {
                return redirect()
                    ->route('users.edit', ['user' => $user->id])
                    ->with('error', 'Als member kan je niet je naam veranderen, vraag een beheerder hiervoor');
            }
        }

        // Email
        if (isset($validatedData['email']) && $validatedData['email'] !== null
            && $user->email !== $validatedData['email']) {
            // Check if request comes from an admin
            if (Gate::allows('manage')) {
                // Check that the email entered is not used yet
                if (User::whereEmail($validatedData['email'])->count() === 0) {
                    $user->email = $validatedData['email'];
                } else {
                    return redirect()
                        ->route('users.edit', ['user' => $user->id])
                        ->with('error', 'Deze email is al bezet');
                }
            } else {
                return redirect()
                    ->route('users.edit', ['user' => $user->id])
                    ->with('error', 'Als member kan je niet je email veranderen, vraag een beheerder hiervoor');
            }
        }

        // Password
        if (isset($validatedData['password']) && $validatedData['password'] !== null &&
            isset($validatedData['old_password']) && $validatedData['old_password'] !== null) {
            if (!$user->updatePassword($validatedData['old_password'], $validatedData['password'])) {
                return back()->with('error', 'Wachtwoord is niet juist');
            }
        }

        // Description
        if (isset($validatedData['description']) && $validatedData['description'] !== null) {
            $user->description = $validatedData['description'];
        }

        // Profile picture
        if (isset($validatedData['profile_picture']) && $validatedData['profile_picture'] !== null) {
            // Store picture
            $picture = $request->file('profile_picture')->store('profile-pictures', ['disk' => 'public']);
            // Remove old picture
            if ($user->profile_picture !== null) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            // Edit user profile picture path
            $user->profile_picture = $picture;
        }

        // If the role field has been set
        if (isset($validatedData['role']) && $validatedData['role'] !== null) {
            if ($validatedData['role'] === 'admin') {
                if (Gate::allows('make-admin', $user)) {
                    $user->role = 'admin';
                } else {
                    return redirect()
                        ->route('users.index')
                        ->with('error', 'Je kunt deze gebruiker geen beheerder maken');
                }
            } else {
                $user->role = 'member';
            }
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Lid is bijgewerkt');
    }

    // Render form for adding new users
    public function create()
    {
        return view('users.create');
    }

    // On submit of register form
    public function store(CreateUserRequest $request)
    {
        // Validate request
        $validatedData = $request->validated();

        // Generated password?
        if (array_key_exists('generate-password', $validatedData) && $validatedData['generate-password'] == "1") {
            // Generate password
            $password = \Str::random(8);
        } else {
            $password = $validatedData['password'];
        }

        $picture = null;
        if (isset($validatedData['profile_picture']) && $validatedData['profile_picture'] !== null) {
            // Upload picture
            $picture = $request->file('profile_picture')->store('profile-pictures', ['disk' => 'public']);
        }

        // Add to the database
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => \Hash::make($password),
            'description' => isset($validatedData['description']) ? $validatedData['description'] : '',
            'profile_picture' => $picture,
            'api_token' => \Str::random(60),
        ]);

        $user->role = 'member';

        // If the role field has been set
        if (isset($validatedData['role']) && $validatedData['role'] !== null) {
            if ($validatedData['role'] === 'admin') {
                if (Gate::allows('make-admin', $user)) {
                    $user->role = 'admin';
                } else {
                    return redirect()
                        ->route('users.index')
                        ->with('error', 'Als beheerder kun je geen beheerders aanmaken');
                }
            }
        }

        $user->save();

        // Send Mail
        Mail::to($validatedData['email'], $validatedData['name'])
            ->queue(new UserRegistered($validatedData['name'], $validatedData['email'], $password));

        // Return view with appropiate message
        return redirect()->route('users.index')->with('success', 'Gebruiker geregistreerd');
    }
}
