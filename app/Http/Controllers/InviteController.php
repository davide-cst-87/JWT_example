<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\InviteUser;

class InviteController extends Controller
{
    public function sendInvitation(Request $request)
    {
    $user = Auth::user(); // This gets the logged-in user
        if (!$user) {
            return response()->json(['error' => 'User not authenticated. Please send a valid token.'], 401);
        }

        // 🔹 Ensure only 'company-admin' can send invites
        if (!$user->hasRole('company-admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'role' => 'required|in:supervisor,staff'
        ]);

        // 🔹 Generate a unique invitation token
        $token = Str::random(32);

        // 🔹 Store the invitation in the database
        $invitation = Invitation::create([
            'company_id' => $user->company_id,
            'email' => $validatedData['email'],
            'token' => $token,
            'role' => $validatedData['role'],
        ]);

        // 🔹 Send invitation email
        Mail::to($validatedData['email'])->send(new InviteUser($invitation));

        return response()->json([
            'message' => 'Invitation sent successfully!',
            'token' => $token  // For testing purposes (can be removed in production)
        ]);
    }
    public function checkInvitation($token)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return response()->json(['error' => 'Invalid invitation token'], 404);
        }

        return response()->json([
            'message' => 'Valid invitation',
            'email' => $invitation->email,
            'role' => $invitation->role,
            'company_id' => $invitation->company_id
        ]);
    }
}
