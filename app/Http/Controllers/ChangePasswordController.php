<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;

class ChangePasswordController extends Controller
{
    public function __construct() {
        // Need to be logged in to change your password
        $this->middleware('auth');
    }

    public function index() {
        return view('users.change-password');
    }

    public function changePassword(Request $request) {
        $validatedData = $request->validate([
            'password-old' => 'required|min:8|string',
            'password-new' => 'required|min:8|string',
        ]);

        $user = $request->user();
        if(Hash::check($validatedData['password-old'], $user->password)) {
            $user->password = Hash::make($validatedData['password-new']);
            $user->save();

            return back()->with('success', 'Wachtwoord veranderd');
        } else {
            return back()->with('error', 'Wachtwoord behoort niet tot dit account');
        }
    }
}
