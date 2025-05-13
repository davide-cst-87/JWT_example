<?php

namespace App\Swagger\Docs\TimeOffRequests;

use OpenApi\Annotations as OA;

/**
 * @OA\Patch(
 *     path="/api/user/timeOff/{id}",
 *     summary="Update a time off request",
 *     description="Allows the authenticated user to update their own time off request, only if the start date has not passed. Only type, start_date, end_date, and note can be modified.",
 *     operationId="updateTimeOffRequest",
 *     tags={"Time Off"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the time off request to update",
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="type", type="string", enum={"holiday", "sickness", "other"}, example="sickness"),
 *             @OA\Property(property="start_date", type="string", format="date", example="2025-07-01"),
 *             @OA\Property(property="end_date", type="string", format="date", example="2025-07-05"),
 *             @OA\Property(property="note", type="string", example="Updated note: doctor's appointment")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Time off request updated successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Time off request updated successfully."),
 *             @OA\Property(property="data", ref="#/components/schemas/TimeOffRequestResource")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized or modification not allowed",
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
 *             @OA\Property(property="message", type="string", example="Time off request not found.")
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
 *                     property="status",
 *                     type="array",
 *
 *                     @OA\Items(type="string", example="You are not allowed to modify the status of a time off request.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
class TimeOffRequest_update {}
