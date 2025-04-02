<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/admin/scans",
 *     summary="Get paginated scans for the admin's company",
 *     tags={"Admin Scans"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number for pagination",
 *         required=false,
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Scans retrieved successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Scans retrieved successfully."),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *
 *                 @OA\Items(ref="#/components/schemas/Scan")
 *             ),
 *
 *             @OA\Property(property="links", type="object",
 *                 @OA\Property(property="first", type="string", example="http://your-app.test/api/admin/scans?page=1"),
 *                 @OA\Property(property="last", type="string", example="http://your-app.test/api/admin/scans?page=5"),
 *                 @OA\Property(property="prev", type="string", nullable=true, example=null),
 *                 @OA\Property(property="next", type="string", nullable=true, example="http://your-app.test/api/admin/scans?page=2"),
 *             ),
 *             @OA\Property(property="meta", type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="from", type="integer", example=1),
 *                 @OA\Property(property="last_page", type="integer", example=5),
 *                 @OA\Property(property="path", type="string", example="http://your-app.test/api/admin/scans"),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="to", type="integer", example=10),
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
class Scan_Admin_index {}
