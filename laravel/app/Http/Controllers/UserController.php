<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserFormRequest;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserTokenActivated;
use App\Mail\AdminNewUserCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function store(CreateUserFormRequest $request)
    {
        $request->validated();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token' => Str::random(10),
        ]);
        if($user){
            Mail::to($user->email)->send(new UserTokenActivated($user));
        }
    return 'user created';

    }

    public function user_confirm($token)
    {
        $user = User::where('token', $token)->first();
        $user->email_verified_at = Carbon::now();
        $user->save();
        /**
         * Also could be a foreach for send the email to every admin in the system
         */
        $admin = User::where('role', Role::ADMIN)->first();
        if($admin){
            Mail::to($admin->email)->send(new AdminNewUserCreated($user));
        }
        return 'User confirmed';
    }
}
