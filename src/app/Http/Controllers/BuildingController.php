<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Building;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BuildingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Получить список зданий",
     *     tags={"Buildings"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1, default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1, maximum=1000, default=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Building"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        return ApiResponse::success(BuildingResource::collection(Building::paginate()));
    }

    /**
     * @OA\Post(
     *     path="/api/buildings",
     *     summary="Создать новое здание",
     *     tags={"Buildings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BuildingCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Здание создано",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Building")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function store(BuildingRequest $request)
    {
        $building = Building::create($request->validated());
        return ApiResponse::created(new BuildingResource($building));
    }

    /**
     * @OA\Get(
     *     path="/api/buildings/{building}",
     *     summary="Получить здание по ID",
     *     tags={"Buildings"},
     *     @OA\Parameter(
     *         name="building",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Building")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Здание не найдено"
     *     )
     * )
     */
    public function show(Building $building)
    {
        return ApiResponse::success(new BuildingResource($building));
    }

    /**
     * @OA\Put(
     *     path="/api/buildings/{building}",
     *     summary="Обновить здание",
     *     tags={"Buildings"},
     *     @OA\Parameter(
     *         name="building",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BuildingUpdate")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Здание обновлено",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Building")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Здание не найдено"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function update(BuildingRequest $request, Building $building)
    {
        $building->update($request->validated());
        return ApiResponse::success(new BuildingResource($building));
    }

    /**
     * @OA\Get(
     *     path="/api/buildings/{building}/organizations",
     *     summary="Получить список организаций в здании",
     *     description="Возвращает пагинированный список всех организаций, принадлежащих конкретному зданию",
     *     tags={"Buildings", "Organizations"},
     *     @OA\Parameter(
     *         name="building",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Номер страницы",
     *         @OA\Schema(type="integer", minimum=1, default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Количество элементов на странице",
     *         @OA\Schema(type="integer", minimum=1, maximum=100, default=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций успешно получен",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Название организации"),
     *                     @OA\Property(
     *                         property="phones",
     *                         type="array",
     *                         @OA\Items(type="string", example="8012421412")
     *                     ),
     *                     @OA\Property(property="building_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-25T15:44:53.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-25T15:44:54.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Здание не найдено",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Building not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function getAllOrganizations(Building $building)
    {
        return ApiResponse::success(OrganizationResource::collection($building->organizations()->paginate()));
    }

    /**
     * @OA\Delete(
     *     path="/api/buildings/{building}",
     *     summary="Удалить здание",
     *     tags={"Buildings"},
     *     @OA\Parameter(
     *         name="building",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Здание удалено"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Здание не найдено"
     *     )
     * )
     */
    public function delete(Building $building)
    {
        $building->delete();
        return response()->noContent();
    }
}
