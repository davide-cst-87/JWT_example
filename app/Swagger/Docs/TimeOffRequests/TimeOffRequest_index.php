<?php

namespace App\Swagger\Docs\TimeOffRequests;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/user/timeOff",
 *     summary="List time off requests for the authenticated user",
 *     description="Returns a paginated list of time off requests belonging to the currently authenticated user. Supports optional filtering by status, type, and date range, and allows sorting.",
 *     operationId="getUserTimeOffRequests",
 *     tags={"Time Off"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="Filter by status: approved, pending, or rejected",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"approved", "pending", "rejected"})
 *     ),
 *
 *     @OA\Parameter(
 *         name="type",
 *         in="query",
 *         description="Filter by type: holiday, sickness, or other",
 *         required=false,
 *
 *         @OA\Schema(type="string", enum={"holiday", "sickness", "other"})
 *     ),
 *
 *     @OA\Parameter(
 *         name="start_date",
 *         in="query",
 *         description="Filter by minimum start date (YYYY-MM-DD)",
 *         required=false,
 *
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Parameter(
 *         name="end_date",
 *         in="query",
 *         description="Filter by maximum end date (YYYY-MM-DD)",
 *         required=false,
 *
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Parameter(
 *         name="date_range[start]",
 *         in="query",
 *         description="Start of custom date range filter (YYYY-MM-DD)",
 *         required=false,
 *
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Parameter(
 *         name="date_range[end]",
 *         in="query",
 *         description="End of custom date range filter (YYYY-MM-DD)",
 *         required=false,
 *
 *         @OA\Schema(type="string", format="date")
 *     ),
 *
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         description="Sort by one or more fields. Prefix with '-' for descending. Allowed: type, status, created_at (e.g., sort=-created_at,type)",
 *         required=false,
 *
 *         @OA\Schema(type="string", example="-created_at,type")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Time off requests retrieved successfully."),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *
 *                 @OA\Items(ref="#/components/schemas/TimeOffRequestResource")
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
class TimeOffRequest_index {}
