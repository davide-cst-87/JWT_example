<?php

namespace App\Swagger\Docs\TimeOffRequests;

use OpenApi\Annotations as OA;

/**
 * @OA\Delete(
 *     path="/api/user/timeOff/{id}",
 *     summary="Delete a time off request",
 *     description="Deletes a time off request if it belongs to the authenticated user.",
 *     operationId="deleteTimeOffRequest",
 *     tags={"Time Off"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the time off request to delete",
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Time off request successfully deleted",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Time Off Request successfully deleted")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized — the request does not belong to the user",
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
 *             @OA\Property(property="message", type="string", example="Time Off Request cannot be found.")
 *         )
 *     )
 * )
 */
class TimeOffRequest_destroy {}
