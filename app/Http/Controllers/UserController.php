<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Redirect;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function setup()
    {        
        return Inertia::render('Auth/Setup');
    }

    public function setupUpdate(Request $request)
    {   
        $user = Auth::User();
        $this->validate($request, [
            'password' => $this->passwordRules(),
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if($user->setup_required) {
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->email),
                'setup_required' => false
            ])->save();

            return Redirect::route('game.index');
        }

        return Redirect::route('keys.create');
    }
}
