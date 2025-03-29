<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();

        if (! $user) {
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
            'name' => 'sometimes|nullable|string|max:255',
            'surname' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|nullable|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed|min:8',
            'phone_number' => 'sometimes|nullable|string|max:20',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hash the password if it exists
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('users', 'public');
            $validated['image'] = $path;
        }

        // Remove empty string/null fields before updating
        $cleanData = collect($validated)
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->toArray();

        $user->update($cleanData);

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
