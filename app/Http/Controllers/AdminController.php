<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Hash;
use App\User;
use App\Mail\UserRegistered;
use Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function viewUsers($message_type = null, $message = null) {
        $active =  User::all()->except(Auth::id());
        $trashed = User::onlyTrashed()->get();
        if(strlen($message_type) > 0) {
            return view('admin.users', ['active' => $active, 'trashed' => $trashed, $message_type => $message]);
        }
        return view('admin.users', compact('active', 'trashed'));
    }

    // Render form for adding new users
    public function add_users() {
        return view('auth.add-users');
    }

    // On submit of register form
    public function register(Request $request) {
        // Validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users|email|max:255|string',
            'password' => 'required_unless:generate-password,on|nullable|min:8|string',
            'generate-password' => 'nullable',
        ]);

        // Generated password?
        if(array_key_exists('generate-password', $validatedData) && $validatedData['generate-password'] == "on") {
            // Generate password
            $password = Str::random(8);
        } else {
            $password = $validatedData['password'];
        }

        // Add to the database
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
        ]);

        // Give member role
        $user->syncRoles(['member']);

        // Send Mail
        Mail::to($validatedData['email'], $validatedData['name'])->send(new UserRegistered($validatedData['name'], $validatedData['email'], $password));
        
        // Return view with appropiate message
        return view('auth.add-users', ['info_message' => 'Gebruiker geregistreerd!']);
    }
}
