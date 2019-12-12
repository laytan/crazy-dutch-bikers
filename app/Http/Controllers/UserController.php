<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
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

    public function trash(Request $request) {
        $validatedData = $request->validate([
            'email' => 'string|max:255|required|email|exists:users,email'
        ]);

        $admin = new AdminController();
        
        $user = User::whereEmail($validatedData['email'])->get()->first();
        if($user->hasRole('admin')) {
            return back()->with('error', 'Gebruiker is een beheerder en kan niet inactief worden gezet');
        }

        $user->delete();
        
        return back()->with('success', 'Gebruiker op inactief gezet');
    }

    public function activate(Request $request) {
        $validatedData = $request->validate([
            'email' => 'string|max:255|required|email|exists:users,email'
        ]);

        $admin = new AdminController();
        
        User::withTrashed()->whereEmail($validatedData['email'])->restore();

        return back()->with('success', 'Gebruiker is geheractiveerd');
    }
}
