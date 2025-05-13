<?php

namespace App\Swagger\Docs\TimeOffRequests;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/user/timeOff",
 *     summary="Create a new time off request",
 *     description="Allows the authenticated user to request time off. Fields like status and approval are handled by the admin and not included here.",
 *     operationId="storeTimeOffRequest",
 *     tags={"Time Off"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(
 *             required={"type", "start_date", "end_date"},
 *
 *             @OA\Property(property="type", type="string", enum={"holiday", "sickness", "other"}, example="holiday"),
 *             @OA\Property(property="start_date", type="string", format="date", example="2025-06-01"),
 *             @OA\Property(property="end_date", type="string", format="date", example="2025-06-10"),
 *             @OA\Property(property="note", type="string", example="Family holiday")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Time off request created successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Time off request created successfully."),
 *             @OA\Property(property="data", ref="#/components/schemas/TimeOffRequestResource")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(
 *                     property="type",
 *                     type="array",
 *
 *                     @OA\Items(type="string", example="The selected type is invalid.")
 *                 )
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
class TimeOffRequest_store {}
