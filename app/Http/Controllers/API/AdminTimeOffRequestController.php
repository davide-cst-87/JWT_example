<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\AdminTimeOffRequestFilter;
use App\Http\Resources\TimeOffRequestResource;
use App\Models\TimeOffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTimeOffRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AdminTimeOffRequestFilter $filters)
    {
        $admin = Auth::user();

        if (! $admin || $admin->account_type !== 'company' || ! $admin->hasRole('company-admin')) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $timeOff = TimeOffRequest::whereHas('user', function ($query) use ($admin) {
            $query->where('company_id', $admin->company_id);
        })
            ->with('user:id,name,surname') // Include user info in response
            ->filter($filters)
            ->with('user')

            ->latest()
            ->paginate(10);

        return TimeOffRequestResource::collection($timeOff)->additional([
            'message' => 'Company time off requests retrieved successfully.',
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
