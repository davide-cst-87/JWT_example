<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Delete(
 *     path="/api/admin/scans/{scan}",
 *     summary="Delete a scan that belongs to the admin's company",
 *     tags={"Admin Scans"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="scan",
 *         in="path",
 *         required=true,
 *         description="ID of the scan to delete",
 *
 *         @OA\Schema(type="integer", example=83)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Scan deleted successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Scan deleted successfully.")
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
class Scan_Admin_delete {}
