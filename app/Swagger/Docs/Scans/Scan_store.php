<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/log-scan",
 *     summary="Log a scan (entrance or exit)",
 *     tags={"Scans"},
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(
 *             required={"badge_id", "type"},
 *
 *             @OA\Property(property="badge_id", type="string", example="ABC123"),
 *             @OA\Property(property="type", type="string", enum={"entrance", "exit"}, example="entrance"),
 *             @OA\Property(property="notes", type="string", example="Came in late"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Scan logged successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Scan logged successfully")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
class Scan_store {}
