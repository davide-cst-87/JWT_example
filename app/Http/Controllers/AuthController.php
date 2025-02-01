<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;


class AuthController extends Controller
{
    // public function register(UserRegisterRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     $user = User::create([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'password' => bcrypt($validatedData['password']),
    //     ]);
    //     $token = auth('api')->login($user);
    //     return $this->respondWithToken($token);
    // }
    public function register(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();
        \Log::info('Registering user', $validatedData);
    
        if ($validatedData['account_type'] === 'company') {
            // Create the company
            $company = Company::create([
                'name' => $validatedData['company_name']
            ]);
    
            // Create user as company admin and explicitly set account_type
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'account_type' => 'company',  // 🔹 Explicitly set account_type
                'company_id' => $company->id,  // 🔹 Ensure company_id is set
            ]);
    
            $user->assignRole('company-admin'); // Assign role
        } else {
            // Create normal user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'account_type' => 'single',  // 🔹 Explicitly set account_type
            ]);
    
            $user->assignRole('user'); // Assign role
        }
        \Log::info('User created:', $user->toArray());
        $token = auth('api')->login($user);
        return $this->respondWithToken($token);
    }



    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    public function me()
    {
        // return response()->json(auth()->user());
        $user = auth()->user()->load('company'); // Eager load company details
        return response()->json($user);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
