<?php

namespace App\Swagger\Docs\TimeOffRequests;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/user/timeOff/{id}",
 *     summary="Get a specific time off request",
 *     description="Returns a specific time off request by ID if it belongs to the authenticated user.",
 *     operationId="getTimeOffRequestById",
 *     tags={"Time Off"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="The ID of the time off request",
 *         required=true,
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Time off request found and returned",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Time off request retrieved successfully."),
 *             @OA\Property(property="data", ref="#/components/schemas/TimeOffRequestResource")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized – the time off request does not belong to the authenticated user",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Unauthorized.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Time off request not found",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Time off request cannot be found.")
 *         )
 *     )
 * )
 */
class TimeOffRequest_show {}
