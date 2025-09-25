<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityCategoryRequest;
use App\Http\Resources\ActivityCategoriesResource;
use App\Models\ActivityCategory;
use App\Utils\ApiResponse;
use OpenApi\Annotations as OA;

class ActivityCategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/activity/category",
     *     summary="Получить список категорий",
     *     tags={"Activity Categories"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ActivityCategory")),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return ApiResponse::success(ActivityCategoriesResource::collection(ActivityCategory::paginate()));
    }

    /**
     * @OA\Post(
     *     path="/api/activity/category",
     *     summary="Создать категорию",
     *     tags={"Activity Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CategoryCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Категория создана",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ActivityCategory"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function store(ActivityCategoryRequest $request)
    {
        return ApiResponse::created(ActivityCategoriesResource::make(ActivityCategory::create($request->validated())));
    }

    /**
     * @OA\Get(
     *     path="/api/activity/category/{category}",
     *     summary="Получить категорию по ID",
     *     tags={"Activity Categories"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ActivityCategory"),
     *         )
     *     ),
     *     @OA\Response(response=404, description="Категория не найдена")
     * )
     */
    public function show(ActivityCategory $activityCategories)
    {
        return ApiResponse::success(ActivityCategoriesResource::make($activityCategories));
    }

    /**
     * @OA\Put(
     *     path="/api/activity/category",
     *     summary="Обновить категорию",
     *     tags={"Activity Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Новое название категории")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ActivityCategory"),
     *         )
     *     ),
     *     @OA\Response(response=404, description="Категория не найдена"),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function update(ActivityCategoryRequest $request, ActivityCategory $activityCategories)
    {
        $activityCategories->update($request->validated());

        return ApiResponse::success(ActivityCategoriesResource::make($activityCategories));
    }

    /**
     * @OA\Delete(
     *     path="/api/activity/category/{category}",
     *     summary="Удалить категорию",
     *     tags={"Activity Categories"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         description="ID категории",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Категория успешно удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Категория не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function delete(ActivityCategory $activityCategories)
    {
        $activityCategories->delete();

        return response()->json(status: 204);
    }
}
