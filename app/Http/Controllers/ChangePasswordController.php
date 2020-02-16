<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;

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
        if ($user->updatePassword($validatedData['password-old'], $validatedData['password-new'])) {
            $user->save();
            return back()->with('success', 'Wachtwoord veranderd');
        } else {
            return back()->with('error', 'Wachtwoorden komen niet overeen');
        }
    }
}
