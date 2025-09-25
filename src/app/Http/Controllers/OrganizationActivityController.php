<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationActivityRequest;
use App\Http\Resources\OrganizationActivityResource;
use App\Models\OrganizationActivity;
use App\Utils\ApiResponse;
use OpenApi\Annotations as OA;

class OrganizationActivityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations/activities",
     *     summary="Получить список активностей организаций",
     *     tags={"Organization Activities"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/OrganizationActivity")),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return ApiResponse::success(OrganizationActivityResource::collection(OrganizationActivity::paginate()));
    }

    /**
     * @OA\Post(
     *     path="/api/organizations/activities",
     *     summary="Создать новую активность организации",
     *     tags={"Organization Activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationActivityCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Активность организации создана",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/OrganizationActivity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function store(OrganizationActivityRequest $request)
    {
        return ApiResponse::created(OrganizationActivityResource::make(OrganizationActivity::create($request->validated())));
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activities/{organizationActivity}",
     *     summary="Получить активность организации по ID",
     *     tags={"Organization Activities"},
     *     @OA\Parameter(
     *         name="organizationActivity",
     *         in="path",
     *         required=true,
     *         description="ID активности организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/OrganizationActivity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Активность организации не найдена"
     *     )
     * )
     */
    public function show(OrganizationActivity $organizationActivity)
    {
        return ApiResponse::success(new OrganizationActivityResource($organizationActivity));
    }

    /**
     * @OA\Put(
     *     path="/api/organizations/activities/{organizationActivity}",
     *     summary="Обновить активность организации",
     *     tags={"Organization Activities"},
     *     @OA\Parameter(
     *         name="organizationActivity",
     *         in="path",
     *         required=true,
     *         description="ID активности организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationActivityUpdate")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Активность организации обновлена",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/OrganizationActivity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Активность организации не найдена"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function update(OrganizationActivityRequest $request, OrganizationActivity $organizationActivity)
    {
        $organizationActivity->update($request->validated());
        return ApiResponse::success(new OrganizationActivityResource($organizationActivity));
    }

    /**
     * @OA\Delete(
     *     path="/api/organizations/activities/{organizationActivity}",
     *     summary="Удалить активность организации",
     *     tags={"Organization Activities"},
     *     @OA\Parameter(
     *         name="organizationActivity",
     *         in="path",
     *         required=true,
     *         description="ID активности организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Активность организации удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Активность организации не найдена"
     *     )
     * )
     */
    public function delete(OrganizationActivity $organizationActivity)
    {
        $organizationActivity->delete();
        return response()->json(status: 204);
    }
}
