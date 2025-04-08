<?php

namespace App\Swagger\Docs\Scans;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/admin/scans",
 *     summary="Manually create a scan for a user (admin-only)",
 *     tags={"Admin Scans"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\RequestBody(
 *         required=true,
 *
 *         @OA\JsonContent(
 *             required={"user_id", "type", "notes"},
 *
 *             @OA\Property(property="user_id", type="integer", example=41),
 *             @OA\Property(property="type", type="string", enum={"entrance", "exit"}, example="entrance"),
 *             @OA\Property(property="notes", type="string", example="manually added for hardware issue")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Scan created successfully",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=95),
 *                 @OA\Property(property="badge_id", type="string", example="85bdb85"),
 *                 @OA\Property(property="type", type="string", example="entrance"),
 *                 @OA\Property(property="notes", type="string", example="manually added for hardware issue"),
 *                 @OA\Property(property="created_at", type="string", example="2025-04-05 11:33:42"),
 *                 @OA\Property(
 *                     property="user",
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=41),
 *                     @OA\Property(property="name", type="string", example="Davide2.0"),
 *                     @OA\Property(property="surname", type="string", nullable=true, example=null)
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Scan created successfully.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized – user does not belong to admin's company",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="Unauthorized.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error – user_id not found or missing fields",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="message", type="string", example="The selected user id is invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(
 *                     property="user_id",
 *                     type="array",
 *
 *                     @OA\Items(type="string", example="The selected user id is invalid.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
class Scan_Admin_store {}
