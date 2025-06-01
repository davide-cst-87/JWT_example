<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Filters\AdminTimeOffRequestFilter;
use App\Http\Resources\TimeOffRequestResource;
use App\Models\TimeOffRequest;
use App\Traits\AdminAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTimeOffRequestController extends Controller
{
    use AdminAuthorization;

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
        $admin = $this->ensureCompanyAdmin();

        $timeOff = TimeOffRequest::where('id', $id)
            ->whereHas('user', function ($query) use ($admin) {
                $query->where('company_id', $admin->company_id);
            })
            ->with('user:id,name,surname')
            ->first();

        if (! $timeOff) {
            return response()->json(['message' => 'Time off request not found or unauthorized.'], 404);
        }

        return new TimeOffRequestResource($timeOff);
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
        $admin = $this->ensureCompanyAdmin();

        $timeOff = TimeOffRequest::where('id', $id)
            ->whereHas('user', function ($query) use ($admin) {
                $query->where('company_id', $admin->company_id);
            })
            ->first();

        if (! $timeOff) {
            return response()->json(['message' => 'Time Off Request not found or unauthorized.'], 404);
        }

        $timeOff->delete(); // Soft delete

        return response()->json(['message' => 'Time Off Request deleted successfully']);

    }
}
