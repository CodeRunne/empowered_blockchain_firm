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
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'telegram_username' => ['required', 'string', 'min:6'],
            'twitter_username' => ['required', 'string', 'min:6'],
            'facebook_username' => ['required', 'string', 'min:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($request->has('referral_token')) {
            $referrer = Referral::where("referral_token", $request->referral_token)->first();

            if(!$referrer) {
                return response()->json(['response' => false]);
            }
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'telegram_username' => $request->telegram_username,
            'twitter_username' => $request->twitter_username,
            'facebook_username' => $request->facebook_username,
            'referral_token' => str()->random(20),
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authtoken')->plainTextToken;

        $user->assignRole('Student');

        if($request->has('referral_token')) {
            Referral::create([
                'user_id' => $user->id, 
                'referrer' => $referrer->id
            ]);
        }

        // event(new Registered($user));

        Auth::login($user);

        return response()->json(["status" => "success", 'token' => $token]);
    }
}