<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{

    public function register(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();
        // \Log::info('Registering user', $validatedData);
    
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
        // \Log::info('User created:', $user->toArray());
        $token = auth('api')->login($user);
        return $this->respondWithToken($token);
    }


    /**
     * Registration from Invitation (Invited Users)
     */
    public function registerFromInvitation(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'token' => 'required|string'
        ]);

        // 🔹 Check if the token exists in the invitations table
        $invitation = Invitation::where('token', $validatedData['token'])->first();

        if (!$invitation) {
            return response()->json(['error' => 'Invalid or expired invitation'], 400);
        }

        // 🔹 Create the user based on the invitation details
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $invitation->email, // Ensure invited email is used
            'password' => Hash::make($validatedData['password']),
            'account_type' => 'company', // Since they belong to a company
            'company_id' => $invitation->company_id,
        ]);

        // 🔹 Assign the invited role
        $user->assignRole($invitation->role);

        // 🔹 Delete the invitation since it's used
        $invitation->delete();

        // 🔹 Authenticate and return a token
        $token = Auth::login($user);

        return response()->json([
            'message' => 'Registration successful!',
            'user' => $user,
            'token' => $token
        ]);
    }


    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // This is a different way to login in terms of syntax but is forcing to use the guard api
        $user = auth('api')->user();

        if ($user->is_blocked) {
        // Logout immediately to invalidate token
        auth('api')->logout();

        return response()->json([
            'message' => 'Your account has been blocked. Please contact your administrator.'
        ], 403);
    }
        return $this->respondWithToken($token);
    }


    public function me()
    {
        // return response()->json(auth()->user());
        // $user = auth()->user()->load('company'); // Eager load company details
        // return response()->json($user);
        $user = auth()->user()->load('roles'); // Load only user's roles

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'account_type' => $user->account_type,
        'company_id' => $user->company_id, // If the user is part of a company
        'roles' => $user->roles->pluck('name') // Return the user's assigned role(s)
    ]);
    }

// THIS IS COMMENT OUT FOR TESTING PURPOSE 
// THIS IS NOT WORKING PROPELERLY BECASUE HANDLE PROPERLY THE SESSION BUT NOT THE TOKEN BASED ( STATELESS)
    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    public function logout()
{
    try {
        auth('api')->invalidate(true); // Blacklists the token
        return response()->json(['message' => 'Successfully logged out']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to log out'], 500);
    }
}

//  this is the old refresh but is better handle better the expections

    // public function refresh()
    // {
    //     return $this->respondWithToken(auth('api')->refresh());
        
    // }

    public function refresh()
{
    try {
        return $this->respondWithToken(auth('api')->refresh());
    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return response()->json(['error' => 'Token expired. Please log in again.'], 401);
    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json(['error' => 'Invalid token.'], 401);
    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json(['error' => 'Could not refresh token. Please log in again.'], 401);
    }
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
