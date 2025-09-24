<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\SecurityScheme(
 *     securityScheme="apiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="X-API-Key",
 *     description="Постоянный API ключ для доступа к API"
 * )
 *
 * // SCHEMAS
 *
 * @OA\Schema(
 *     schema="Activity",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Утренняя пробежка"),
 *     @OA\Property(property="activity_category_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00Z")
 * )
 *
 * @OA\Schema(
 *     schema="ActivityCategory",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Спорт"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00Z")
 * )
 *
 * @OA\Schema(
 *     schema="ActivityCreate",
 *     required={"name", "activity_category_id"},
 *     @OA\Property(property="name", type="string", maxLength=255, example="Утренняя пробежка"),
 *     @OA\Property(property="activity_category_id", type="integer", example=1)
 * )
 *
 * @OA\Schema(
 *     schema="ActivityUpdate",
 *     @OA\Property(property="name", type="string", maxLength=255, example="Вечерняя пробежка"),
 *     @OA\Property(property="activity_category_id", type="integer", example=2)
 * )
 *
 * @OA\Schema(
 *     schema="CategoryCreate",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", maxLength=255, example="Спорт")
 * )
 *
 * @OA\Schema(
 *     schema="CategoryUpdate",
 *     @OA\Property(property="name", type="string", maxLength=255, example="Фитнес")
 * )
 *
 * @OA\Schema(
 *      schema="ValidationError",
 *      @OA\Property(property="success", type="boolean", example=false),
 *      @OA\Property(
 *          property="data",
 *          type="object",
 *          @OA\AdditionalProperties(
 *              type="array",
 *              @OA\Items(type="string")
 *          )
 *      )
 *  )
 */
abstract class Controller
{
    //
}
