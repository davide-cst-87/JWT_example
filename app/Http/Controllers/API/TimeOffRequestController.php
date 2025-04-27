<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TimeOffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeOffRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return 'Hello World';
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $query = TimeOffRequest::where('user_id', $user->id)->with(['user:id,name,surname']);

        $timeOff = $query->latest()->paginate(10);

        return response()->json([
            'message' => 'Data retrieved',
            'timeOff' => $timeOff,
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
