<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __invoke()
    {
        $users = User::where('role', User::ROLE_USER)->latest()->paginate(10);

        return view('admin.user', compact('users'));
    }
}
