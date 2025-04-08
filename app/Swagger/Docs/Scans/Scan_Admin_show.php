<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/admin/scans/{scan}",
 *     summary="Get a specific scan by ID (only within the admin's company)",
 *     tags={"Admin Scans"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="scan",
 *         in="path",
 *         required=true,
 *         description="ID of the scan to retrieve",
 *
 *         @OA\Schema(type="integer", example=83)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Scan retrieved successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=83),
 *                 @OA\Property(property="badge_id", type="string", example="85bdb85"),
 *                 @OA\Property(property="type", type="string", example="entrance"),
 *                 @OA\Property(property="notes", type="string", nullable=true, example=null),
 *                 @OA\Property(property="created_at", type="string", example="2025-03-30 00:51:44"),
 *                 @OA\Property(
 *                     property="user",
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=41),
 *                     @OA\Property(property="name", type="string", example="Davide2.0"),
 *                     @OA\Property(property="surname", type="string", nullable=true, example=null)
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Scan retrieved successfully")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden – scan does not belong to admin's company"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Scan not found"
 *     )
 * )
 */
class Scan_Admin_show {}
