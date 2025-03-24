<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::user();

        $users = User::where('company_id', $admin->company_id)
            ->with('roles') // eager load roles
            ->paginate(10);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Auth::user();

        $user = User::where('id', $id)
            ->where('company_id', $admin->company_id)
            ->with('roles', 'company')
            ->first();

        if (! $user) {
            return response()->json([
                'message' => 'User not found or does not belong to your company.',
            ], 404);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $admin = Auth::user();

        $user = User::where('id', $id)
            ->where('company_id', $admin->company_id)
            ->first();

        if (! $user) {
            return response()->json(['message' => 'User not found or forbidden.'], 404);
        }

        // ✅ Only validate fields the admin is allowed to edit
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,'.$user->id,
            'role' => 'sometimes|string|exists:roles,name',
            // 'badge_id' => 'sometimes|string|max:100',
        ]);

        // 🔹 Update allowed fields (excluding role)
        $userData = collect($validated)->except(['role'])->toArray();
        $user->update($userData);

        // 🔄 Update role via Spatie (if provided)
        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        // ✅ Return updated user as resource
        return response()->json([
            'message' => 'User updated successfully.',
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

    /**
     * Block the specified user
     */
    public function block(string $id)
    {
        $admin = Auth::user();

        $user = User::where('id', $id)
            ->where('company_id', $admin->company_id)
            ->first();

        if (! $user) {
            return response()->json([
                'message' => 'User not found or does not belong to your company.',
            ], 404);
        }

        $user->is_blocked = true;
        $user->save();

        return response()->json([
            'message' => 'User has been successfully blocked.',
            'user' => new UserResource($user->fresh('roles', 'company')),
        ]);
    }

    /**
     * UnBlock the specified user
     */
    public function unblock(string $id)
    {
        $admin = Auth::user();

        $user = User::where('id', $id)
            ->where('company_id', $admin->company_id)
            ->first();

        if (! $user) {
            return response()->json([
                'message' => 'User not found or does not belong to your company.',
            ], 404);
        }

        $user->is_blocked = false;
        $user->save();

        return response()->json([
            'message' => 'User has been successfully unblocked.',
            'user' => new UserResource($user->fresh('roles', 'company')),
        ]);
    }
}
