<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TimeOffRequestResource",
 *     type="object",
 *     title="Time Off Request Resource",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="type", type="string", example="holiday"),
 *     @OA\Property(property="start_date", type="string", format="date", example="2025-06-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2025-06-10"),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-09T12:00:00Z")
 * )
 */
class TimeOffRequestResources {}
