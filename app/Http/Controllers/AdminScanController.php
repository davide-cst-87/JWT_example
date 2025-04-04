<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScanResource;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminScanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Auth::user();

        if (! $admin) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // This code below is needed to filter based on the user that has the same
        // company_id as the company that the admin is
        $scans = Scan::whereHas('user', function ($query) use ($admin) {
            $query->where('company_id', $admin->company_id);
        })->with('user')->paginate(10);

        // This is the right way to use the Resources because in this way
        // the meta data retrieved from the pagination if used inside a json( )
        // the meta gonna be lost
        return ScanResource::collection($scans)->additional([
            'message' => 'Scans retrieved successfully.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Scan $scan)
    {
        $this->authorizeScan($scan);

        return new ScanResource($scan)->additional(['message' => 'Scan retrieved successfully']);
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

    // This is an helper function that is used to authorize the scan
    private function authorizeScan(Scan $scan)
    {
        $admin = Auth::user();

        if (! $admin) {
            abort(401, 'Unauthenticated.');
        }

        if ($scan->user->company_id !== $admin->company_id) {
            abort(403, 'Forbidden.');
        }
    }
}
