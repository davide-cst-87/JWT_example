<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
   

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
    
        $user->load('roles', 'company');
    
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
    
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|confirmed|min:8',
        ]);
    
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
    
        $user->update($validated);
    
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => new UserResource($user->fresh('roles', 'company')),
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
