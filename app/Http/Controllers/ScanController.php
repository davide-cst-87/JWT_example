<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge_id' => 'required|string|max:255',
            'type' => 'required|in:entrance,exit',
            'notes' => 'nullable|string|max:255',
        ]);

        // (Optional) Find user by badge
        $user = User::where('badge_id', $validated['badge_id'])->first();

        Scan::create([
            'badge_id' => $validated['badge_id'],
            'user_id' => $user?->id, // null if not found
            'type' => $validated['type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Scan logged successfully',
        ], 201);
    }
}
