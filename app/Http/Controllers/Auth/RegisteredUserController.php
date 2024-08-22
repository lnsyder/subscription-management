<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'payment_provider' => $request->input('payment_provider')
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->json(['user' => $user], 201);
    }
}
