<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\UserRegistered;
use Auth;
use Mail;

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
        $this->middleware('role:super-admin|admin')->only(['trash', 'activate', 'create', 'store']);
        $this->middleware('sameOrAdmin')->only(['edit', 'update']);
    }

    /**
     * View all users
     */
    public function index($message_type = null, $message = null) {
        $active  = User::all();
        $trashed = User::onlyTrashed()->get();

        // Resolve full profile picture or placeholder
        $active  = resolveProfilePics($active);
        $trashed = resolveProfilePics($trashed);
        
        if(strlen($message_type) > 0) {
            return view('users.index', ['active' => $active, 'trashed' => $trashed, $message_type => $message]);
        }
        return view('users.index', compact('active', 'trashed'));
    }

    /**
     * Put a user in the trash
     */
    public function destroy(Request $request) {
        $validatedData = $request->validate([
            'email' => 'string|max:255|required|email|exists:users,email'
        ]);
        
        $user = User::whereEmail($validatedData['email'])->get()->first();
        if($user->hasRole('super-admin')) {
            return back()->with('error', 'Hoofdgebruiker kan niet inactief worden gezet.');
        }

        if($user->hasRole('admin') && !Auth::user()->hasRole('super-admin')) {
            return back()->with('error', 'Gebruiker is ook een beheerder en kan dus alleen door de hoofdgebruiker verwijderd worden.');
        }

        $user->delete();
        
        return back()->with('success', 'Gebruiker op inactief gezet');
    }

    /**
     * Reactivate user from trash
     */
    public function activate(Request $request) {
        $validatedData = $request->validate([
            'email' => 'string|max:255|required|email|exists:users,email'
        ]);

        $admin = new AdminController();
        
        User::withTrashed()->whereEmail($validatedData['email'])->restore();

        return back()->with('success', 'Gebruiker is geheractiveerd');
    }

    /**
     * View to edit a user
     */
    public function edit(Request $request, $id) {
        $user = resolveProfilePic(User::findOrFail($id));
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id) {
        // Validate request
        $validatedData = $request->validate([
            'name'            => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:255|string',
            'old_password'    => 'nullable|min:8|string',
            'password'        => 'nullable|min:8|string',
            'description'     => 'nullable|string',
            'profile_picture' => 'nullable|image',
            'role'            => 'nullable|in:member,admin',
        ]);
        
        $user = User::findOrFail($id);

        // Name
        if($validatedData['name'] !== null) {
            $user->name = $validatedData['name'];
        }

        // Email
        if($validatedData['email'] !== null && $user->email !== $validatedData['email']) {
            if (User::whereEmail($validatedData['email'])->count() === 0) {
                $user->email = $validatedData['email'];
            }
        }

        // Password
        if($validatedData['password'] !== null && $validatedData['old_password'] !== null) {
            // Check password
            if(\Hash::check($validatedData['old_password'], $user->password)) {
                // Update password
                $user->password = \Hash::make($validatedData['password']);
            } else {
                return back()->with('error', 'Wachtwoord is niet juist');
            }
        }

        // Description
        if($validatedData['description'] !== null) {
            $user->description = $validatedData['description'];
        }

        // Profile picture
        if(isset($validatedData['profile_picture']) && $validatedData['profile_picture'] !== null) {
            // Store picture
            $picture = $request->file('profile_picture')->store('profile-pictures', ['disk' => 'public']);
            // Remove old picture
            if($user->profile_picture !== null) {
                \Storage::disk('public')->delete($user->profile_picture);
            }
            // Edit user profile picture path
            $user->profile_picture = $picture;
        }

        if(isset($validatedData['role']) && $validatedData['role'] !== null) {
            if(Auth::user()->hasRole('super-admin') && $validatedData['role'] === 'admin') {
                $user->syncRoles(['admin']);
            } else {
                $user->syncRoles(['member']);
            }
        }

        $user->save();

        return redirect()->route('users-index')->with('success', 'Lid is bewerkt');
    }

    // Render form for adding new users
    public function create() {
        return view('users.create');
    }

    // On submit of register form
    public function store(Request $request) {
        // Validate request
        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|unique:users|email|max:255|string',
            'password'          => 'required_unless:generate-password,on|nullable|min:8|string',
            'generate-password' => 'nullable',
            'description'       => 'nullable|string',
            'profile_picture'   => 'nullable|image',
            'role'              => 'nullable|in:member,admin',
        ]);

        // Generated password?
        if(array_key_exists('generate-password', $validatedData) && $validatedData['generate-password'] == "on") {
            // Generate password
            $password = \Str::random(8);
        } else {
            $password = $validatedData['password'];
        }

        $picture = null;
        if(isset($validatedData['profile_picture']) && $validatedData['profile_picture'] !== null) {
            // Upload picture
            $picture = $request->file('profile_picture')->store('profile-pictures', ['disk' => 'public']);
        }

        // Add to the database
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => \Hash::make($password),
            'description' => $validatedData['description'],
            'profile_picture' => $picture,
        ]);

        if(Auth::user()->hasRole('super-admin') && $validatedData['role'] === 'admin') {
            $user->syncRoles(['admin']);
        } else {
            // Give member role
            $user->syncRoles(['member']);
        }

        // Send Mail
        Mail::to($validatedData['email'], $validatedData['name'])->queue(new UserRegistered($validatedData['name'], $validatedData['email'], $password));
        
        // Return view with appropiate message
        return redirect()->route('users-index')->with('info', 'Gebruiker geregistreerd!');
    }
}
