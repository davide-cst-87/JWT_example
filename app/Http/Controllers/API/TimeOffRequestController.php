<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\TimeOffRequestFilter;
use App\Http\Requests\StoreTimeOffRequest;
use App\Http\Resources\TimeOffRequestResource;
use App\Models\TimeOffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeOffRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TimeOffRequestFilter $filters)
    {

        $user = Auth::user();

        // Below I have implemented the filters in a cleanear way to mantain the controller clean and sleak
        // without using a bunch of if elif else statment
        $timeOff = TimeOffRequest::where('user_id', $user->id)
            ->filter($filters)
            ->latest()
            ->paginate(10);

        return TimeOffRequestResource::collection($timeOff)->additional([
            'message' => 'Time off requests retrieved successfully.',
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimeOffRequest $request)
    {

        $validated = $request->validated();

        $timeOff = TimeOffRequest::create([
            'user_id' => $request->user()->id,
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'note' => $validated['note'] ?? null,
        ]);

        $timeOff->refresh();

        return response()->json([
            'message' => 'Time off request created successfully.',
            'data' => new TimeOffRequestResource($timeOff),
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $timeoff = TimeOffRequest::findOrFail($id);

            // Check if the current user is the owner of the request
            if ($timeoff->user_id !== auth()->id()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            $timeoff->delete();

            return response()->json(['message' => 'Time Off Request successfully deleted'], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => 'Time Off Request cannot be found.'], 404);
        }
    }
}
