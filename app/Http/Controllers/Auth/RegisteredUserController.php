<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($request->has('referral_token')) {
            $referrer = Referral::where("referral_token", $request->referral_token)->first();

            if(!$referrer) {
                return response()->json(['response' => false]);
            }
                
            $user = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Referral::create([
                'user_id' => $user->id, 
                'referrer' => $referrer->id
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}