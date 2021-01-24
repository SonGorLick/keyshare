<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->withUser($user);
    }
}
