<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\TimeOffRequestFilter;
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

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // $query = TimeOffRequest::where('user_id', $user->id)->with(['user:id,name,surname']);

        // if ($request->filled('status') && in_array($request->status, ['approved', 'pending', 'rejected'])) {
        //     $query->where('status', $request->status);
        // }

        // if ($request->filled('type') && in_array($request->type, ['holiday', 'sickness', 'other'])) {
        //     $query->where('type', $request->type);
        // }

        // if ($request->filled('start_date') && $request->filled('end_date')) {
        //     $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        // } elseif ($request->filled('start_date')) {
        //     $query->whereDate('start_date', '>=', $request->start_date);
        // } elseif ($request->filled('end_date')) {
        //     $query->whereDate('end_date', '>=', $request->end_date);
        // }

        // $timeOff = $query->latest()->paginate(10);

        $timeOff = TimeOffRequest::where('user_id', $user->id)
            ->with(['user:id,name,surname'])
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
    public function store(Request $request)
    {
        //
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
        //
    }
}
