<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Mail\UserRegistered;
use Auth;
use Mail;
use App\Http\Requests\CreateUserRequest;

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
        $users = resolveProfilePics(User::all());
        
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
            'name'            => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:255|string',
            'old_password'    => 'nullable|min:8|string',
            'password'        => 'nullable|min:8|string',
            'description'     => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role'            => 'nullable|in:member,admin',
        ]);

        // Name
        if ($validatedData['name'] !== null) {
            $user->name = $validatedData['name'];
        }

        // Email
        if ($validatedData['email'] !== null && $user->email !== $validatedData['email']) {
            if (User::whereEmail($validatedData['email'])->count() === 0) {
                $user->email = $validatedData['email'];
            }
        }

        // Password
        if ($validatedData['password'] !== null && $validatedData['old_password'] !== null) {
            // Check password
            if (\Hash::check($validatedData['old_password'], $user->password)) {
                // Update password
                $user->password = \Hash::make($validatedData['password']);
            } else {
                return back()->with('error', 'Wachtwoord is niet juist');
            }
        }

        // Description
        if ($validatedData['description'] !== null) {
            $user->description = $validatedData['description'];
        }

        // Profile picture
        if (isset($validatedData['profile_picture']) && $validatedData['profile_picture'] !== null) {
            // Store picture
            $picture = $request->file('profile_picture')->store('profile-pictures', ['disk' => 'private']);
            // Remove old picture
            if ($user->profile_picture !== null) {
                \Storage::disk('private')->delete($user->profile_picture);
            }
            // Edit user profile picture path
            $user->profile_picture = $picture;
        }

        // If the user is assigned admin and the authorized user can to do that
        if (isset($validatedData['role'])      &&
            $validatedData['role'] !== null    &&
            $validatedData['role'] === 'admin' &&
            Gate::allows('make-admin', $user)
        ) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Lid is bewerkt');
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
        if (array_key_exists('generate-password', $validatedData) && $validatedData['generate-password'] == "on") {
            // Generate password
            $password = \Str::random(8);
        } else {
            $password = $validatedData['password'];
        }

        $picture = null;
        if (isset($validatedData['profile_picture']) && $validatedData['profile_picture'] !== null) {
            // Upload picture
            $picture = $request->file('profile_picture')->store('profile-pictures', ['disk' => 'private']);
        }

        // Add to the database
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => \Hash::make($password),
            'description' => $validatedData['description'],
            'profile_picture' => $picture,
        ]);

        // If the user is assigned admin and the authorized user can to do that
        if (isset($validatedData['role'])      &&
            $validatedData['role'] !== null    &&
            $validatedData['role'] === 'admin' &&
            Gate::allows('make-admin', $user)
        ) {
            $user->role = 'admin';
        } else {
            $user->role = 'member';
        }

        // Send Mail
        Mail::to($validatedData['email'], $validatedData['name'])
            ->queue(new UserRegistered($validatedData['name'], $validatedData['email'], $password));
        
        // Return view with appropiate message
        return redirect()->route('users.index')->with('success', 'Gebruiker geregistreerd');
    }

    public function picture($profile_picture)
    {
        $path = "app/private/profile-pictures/$profile_picture";
        return file_response($path);
    }
}
