<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Scan",
 *     title="Scan",
 *     description="Represents a user scan event",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="badge_id", type="string", example="ABC123XYZ"),
 *     @OA\Property(property="type", type="string", enum={"entrance", "exit"}, example="entrance"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Came in late"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T09:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-01T09:05:00Z"),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         @OA\Property(property="name", type="string", example="Mario"),
 *         @OA\Property(property="surname", type="string", example="Rossi")
 *     )
 * )
 */
class ScanSchema {}
