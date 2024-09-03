<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function api_login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->orWhere('phone',$request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email or Password is incorrect. Please double-check and try again.'],
            ]);
        }

        $expirationDays = $request->filled('remember_me') ? 7 : 1;
        $expirationTime = Carbon::now()->addDays($expirationDays);

        $token = $user->createToken($user->name)->plainTextToken;
        $tokenId = $user->tokens()->latest()->first()->id;

        $user->tokens()->where('id', $tokenId)->update(['created_at' => $expirationTime]);
        return [
            'token' => $token,
            'user' => $user
        ];
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'digits:11', 'unique:users,phone'],
            'email' => ['nullable', 'email'],
            'address' => ['required', 'string'],
            'password'=>['required','min:4']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => 2,
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json(['token' => $token,'user'=>$user], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
