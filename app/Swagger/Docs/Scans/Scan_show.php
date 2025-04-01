<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/user/my-scan/{id}",
 *     summary="Get a specific scan by ID (only if owned by the authenticated user)",
 *     tags={"Scans"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the scan to retrieve",
 *         required=true,
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Scan retrieved successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Data retrieved"),
 *             @OA\Property(property="scan", ref="#/components/schemas/Scan")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Scan not found"
 *     )
 * )
 */
class Scan_show {}
