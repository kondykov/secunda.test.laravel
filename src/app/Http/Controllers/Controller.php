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
 *     @OA\Property(property="name", type="string", example="Автомобили"),
 *     @OA\Property(property="parent_id", type="integer", example=1),
 *     @OA\Property(property="is_category", type="boolena", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00Z")
 * )
 *
 * @OA\Schema(
 *     schema="ActivityCreate",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", maxLength=255, example="Автомобили"),
 *     @OA\Property(property="parent_id", type="integer", example=1),
 *     @OA\Property(property="is_category", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="ActivityUpdate",
 *     @OA\Property(property="name", type="string", maxLength=255, example="Еда"),
 *     @OA\Property(property="parent_id", type="integer", example=2),
 *     @OA\Property(property="is_category", type="boolean", example=false),
 * )
 *
 * @OA\Schema(
 *      schema="Building",
 *      type="object",
 *      title="Building",
 *      description="Модель здания/строения",
 *      required={"description", "address", "longitude", "latitude"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64",
 *          description="ID здания",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Описание здания",
 *          example="Офисное здание бизнес-центра"
 *      ),
 *      @OA\Property(
 *          property="address",
 *          type="string",
 *          description="Адрес здания",
 *          example="ул. Примерная, д. 123"
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="float",
 *          description="Долгота",
 *          example=55.751244
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="float",
 *          description="Широта",
 *          example=37.618423
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          description="Дата создания"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          description="Дата обновления"
 *      )
 *  )
 *
 * @OA\Schema(
 *      schema="BuildingCreate",
 *      type="object",
 *      title="Building Create",
 *      description="Данные для создания здания",
 *      required={"description", "address", "longitude", "latitude"},
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Описание здания",
 *          example="Офисное здание бизнес-центра"
 *      ),
 *      @OA\Property(
 *          property="address",
 *          type="string",
 *          description="Адрес здания",
 *          example="ул. Примерная, д. 123"
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="float",
 *          description="Долгота",
 *          example=55.751244
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="float",
 *          description="Широта",
 *          example=37.618423
 *      )
 *  )
 *
 * @OA\Schema(
 *      schema="BuildingUpdate",
 *      type="object",
 *      title="Building Update",
 *      description="Данные для обновления здания",
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Описание здания",
 *          example="Обновленное описание здания"
 *      ),
 *      @OA\Property(
 *          property="address",
 *          type="string",
 *          description="Адрес здания",
 *          example="ул. Обновленная, д. 456"
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="float",
 *          description="Долгота",
 *          example=55.755826
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="float",
 *          description="Широта",
 *          example=37.617300
 *      )
 *  )
 *
 * @OA\Schema(
 *      schema="Organization",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name", type="string", example="Название организации"),
 *      @OA\Property(
 *          property="phones",
 *          type="array",
 *          @OA\Items(type="string", example="8012421412")
 *      ),
 *      @OA\Property(property="building_id", type="integer", example=1),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time")
 *  )
 *
 * @OA\Schema(
 *      schema="OrganizationCreate",
 *      type="object",
 *      required={"name"},
 *      @OA\Property(property="name", type="string", example="Новая организация")
 *  )
 *
 * @OA\Schema(
 *      schema="OrganizationUpdate",
 *      type="object",
 *      @OA\Property(property="name", type="string", example="Обновленное название организации")
 *  )
 *
 * @OA\Schema(
 *      schema="OrganizationActivity",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="organization_id", type="integer", example=1),
 *      @OA\Property(property="activity_id", type="integer", example=1),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time")
 *  )
 *
 * @OA\Schema(
 *      schema="OrganizationActivityCreate",
 *      type="object",
 *      required={"organization_id", "activity_id"},
 *      @OA\Property(property="organization_id", type="integer", example=1),
 *      @OA\Property(property="activity_id", type="integer", example=1)
 *  )
 *
 * @OA\Schema(
 *      schema="OrganizationActivityUpdate",
 *      type="object",
 *      @OA\Property(property="organization_id", type="integer", example=1),
 *      @OA\Property(property="activity_id", type="integer", example=2)
 *  )
 *
 * @OA\Schema(
 *      schema="PaginationMeta",
 *      type="object",
 *      @OA\Property(property="current_page", type="integer", example=1),
 *      @OA\Property(property="from", type="integer", example=1),
 *      @OA\Property(property="last_page", type="integer", example=10),
 *      @OA\Property(property="path", type="string", example="http://localhost/api/buildings"),
 *      @OA\Property(property="per_page", type="integer", example=20),
 *      @OA\Property(property="to", type="integer", example=20),
 *      @OA\Property(property="total", type="integer", example=200)
 *  )
 *
 * @OA\Schema(
 *      schema="PaginationLinks",
 *      type="object",
 *      @OA\Property(property="first", type="string", example="http://localhost/api/buildings?page=1"),
 *      @OA\Property(property="last", type="string", example="http://localhost/api/buildings?page=10"),
 *      @OA\Property(property="prev", type="string", example="http://localhost/api/buildings?page=1"),
 *      @OA\Property(property="next", type="string", example="http://localhost/api/buildings?page=2")
 *  )
 *
 * @OA\Schema(
 *      schema="ApiStaticKey",
 *      type="object",
 *      description="Статический API ключ",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="name", type="string", example="Мобильное приложение"),
 *      @OA\Property(property="key", type="string", example="sk_live_1234567890abcdef"),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time")
 *  )
 *
 * @OA\Schema(
 *      schema="ApiStaticKeyCreate",
 *      type="object",
 *      required={"name", "key"},
 *      description="Данные для создания API ключа",
 *      @OA\Property(property="name", type="string", maxLength=255, example="Мобильное приложение"),
 *      @OA\Property(property="key", type="string", maxLength=255, example="sk_live_1234567890abcdef")
 *  )
 *
 * @OA\Schema(
 *      schema="ApiStaticKeyUpdate",
 *      type="object",
 *      description="Данные для обновления API ключа",
 *      @OA\Property(property="name", type="string", maxLength=255, example="Обновленное название"),
 *      @OA\Property(property="key", type="string", maxLength=255, example="sk_live_updated_key")
 *  )
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
