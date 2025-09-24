<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/activity",
     *     summary="Получить список видов деятельности",
     *     tags={"Activities"},
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
     *     @OA\Parameter(
     *         name="activity_category_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Activity")),
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $categoryId = $request->input('activity_category_id') ?? null;

        if ($categoryId) {
            $activities = Activity::where('activity_category_id', $categoryId)->paginate();
        } else {
            $activities = Activity::paginate();
        }

        return ApiResponse::success(ActivityResource::collection($activities));
    }

    /**
     * @OA\Post(
     *     path="/api/activity",
     *     summary="Добавить вид деятельности",
     *     tags={"Activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ActivityCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Вид деятельности добавлен",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Activity"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function store(ActivityRequest $request)
    {
        return ApiResponse::created(new ActivityResource(Activity::create($request->validated())));
    }

    /**
     * @OA\Get(
     *     path="/api/activity/{activity}",
     *     summary="Получить вид деятельности по ID",
     *     tags={"Activities"},
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Activity"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Не найдено",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="data", type="string", example="Activity not found")
     *         )
     *     )
     * )
     */
    public function show(Activity $activity)
    {
        return ApiResponse::success(new ActivityResource($activity));
    }

    /**
     * @OA\Put(
     *     path="/api/activity",
     *     summary="Обновить вид деятельности",
     *     tags={"Activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Новое название"),
     *             @OA\Property(property="activity_category_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Activity"),
     *         )
     *     ),
     *     @OA\Response(response=404, description="Вид деятельности не найден"),
     *     @OA\Response(
     *          response=422,
     *          description="Ошибка валидации",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *      )
     * )
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());

        return ApiResponse::success(new ActivityResource($activity));
    }

    /**
     * @OA\Delete(
     *     path="/api/activity/{activity}",
     *     summary="Удалить вид деятельности",
     *     tags={"Activities"},
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         required=true,
     *         description="ID вида деятельности",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Вид деятельности успешно удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Вид деятельности не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Activity not found")
     *         )
     *     )
     * )
     */
    public function delete(Activity $activity)
    {
        $activity->delete();

        return response()->json(status: 204);
    }
}
