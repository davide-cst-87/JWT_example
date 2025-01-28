<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Scan;  // Add this line
// use Carbon\Carbon;

// class ScanController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         {
//             // Validate incoming request
//             $validated = $request->validate([
//                 'badge_id'  => 'required|string|max:255',
//                 'timestamp' => 'required|integer',
//             ]);
    
//             // Store the log entry
//             $scan = Scan::create([
//                 'badge_id'  => $validated['badge_id'],
//                 'timestamp' => Carbon::createFromTimestamp($validated['timestamp'])->toDateTimeString(),
//             ]);
    
//             return response()->json([
//                 'message' => 'Scan logged successfully',
//                 'data'    => $scan,
//             ], 201);
//         }
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;  // Add this line
use Carbon\Carbon;

class ScanController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'badge_id'  => 'required|string|max:255',
            'timestamp' => 'required|integer',
        ]);

        Scan::create([
            'badge_id'  => $validated['badge_id'],
            'timestamp' => Carbon::createFromTimestamp($validated['timestamp'])->toDateTimeString(),
        ]);

        return response()->json([
            'message' => 'Scan logged successfully'
        ], 201);
    }
}
