<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
use App\Http\Requests\changePasswordRequest;
use Gate;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('index')->with('showChangePassword', 'true');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $validatedData = $request->validated();
        $user = $request->user();
        $user->updatePassword($validatedData['password-new']);
        $user->save();
        return back()->with('success', 'Wachtwoord veranderd');
    }
}
