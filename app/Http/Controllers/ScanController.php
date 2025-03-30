<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/log-scan",
     *     summary="Log a scan (entrance or exit)",
     *     tags={"Scans"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"badge_id", "type"},
     *
     *             @OA\Property(property="badge_id", type="string", example="ABC123"),
     *             @OA\Property(property="type", type="string", enum={"entrance", "exit"}, example="entrance"),
     *             @OA\Property(property="notes", type="string", example="Came in late"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Scan logged successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Scan logged successfully")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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
