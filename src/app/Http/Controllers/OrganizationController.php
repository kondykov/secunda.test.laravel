<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Utils\ApiResponse;
use OpenApi\Annotations as OA;

class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations",
     *     summary="Получить список организаций",
     *     tags={"Organizations"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return ApiResponse::success(OrganizationResource::collection(Organization::paginate()));
    }

    /**
     * @OA\Post(
     *     path="/api/organizations",
     *     summary="Создать новую организацию",
     *     tags={"Organizations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Организация создана",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function store(OrganizationRequest $request)
    {
        return ApiResponse::created(new OrganizationResource(Organization::create($request->validated())));
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{organization}",
     *     summary="Получить организацию по ID",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена"
     *     )
     * )
     */
    public function show(Organization $organization)
    {
        return ApiResponse::success(new OrganizationResource($organization));
    }

    /**
     * @OA\Put(
     *     path="/api/organizations/{organization}",
     *     summary="Обновить организацию",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationUpdate")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Организация обновлена",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function update(OrganizationRequest $request, Organization $organization)
    {
        $organization->update($request->validated());
        return ApiResponse::success(new OrganizationResource($organization));
    }

    /**
     * @OA\Delete(
     *     path="/api/organizations/{organization}",
     *     summary="Удалить организацию",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Организация удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена"
     *     )
     * )
     */
    public function delete(Organization $organization)
    {
        $organization->delete();
        return response()->json(status: 204);
    }
}
