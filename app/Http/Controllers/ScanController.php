<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScanResource;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function index(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $query = Scan::where('user_id', $user->id)->with(['user:id,name,surname']);

        // Optional filter by scan type
        if ($request->has('type') && in_array($request->type, ['entrance', 'exit'])) {
            $query->where('type', $request->type);
        }

        // Optional filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $scans = $query->latest()->paginate(10);

        return response()->json([
            'message' => 'Data retrieved',
            'scans' => ScanResource::collection($scans),
        ]);
    }
}
