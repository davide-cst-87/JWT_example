<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/user/my-scan",
 *     summary="Get authenticated user's scans (entrance or exit)",
 *     tags={"Scans"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         description="Filter by scan type (entrance or exit)",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"entrance", "exit"})
 *     ),
 *
 *     @OA\Parameter(
 *         name="start_date",
 *         in="query",
 *         description="Start date for filtering (YYYY-MM-DD)",
 *         required=false,
 *
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Parameter(
 *         name="end_date",
 *         in="query",
 *         description="End date for filtering (YYYY-MM-DD)",
 *         required=false,
 *
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Scans retrieved successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Data retrieved"),
 *             @OA\Property(
 *                 property="scans",
 *                 type="object",
 *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Scan")),
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="last_page", type="integer", example=5),
 *                 @OA\Property(property="total", type="integer", example=50)
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     )
 * )
 */
class Scan_index {}
