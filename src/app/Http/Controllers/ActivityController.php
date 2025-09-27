<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Interfaces\ActivityServiceInterface;
use App\Models\Activity;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ActivityController extends Controller
{

    public function __construct(
        private ActivityServiceInterface $activityService,
    )
    {
    }

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
     *         name="parent_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *          name="root_only",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="boolean")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Activity"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Activity::with('parent');

        if ($request->has('type')) {
            if ($request->type === 'categories') {
                $query->categories();
            } elseif ($request->type === 'activities') {
                $query->activities();
            }
        }

        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        } elseif ($request->boolean('roots_only')) {
            $query->rootCategories();
        }

        return ApiResponse::success(ActivityResource::collection($query->paginate()));
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
     *             @OA\Property(property="message", type="string", example="Activity not found")
     *         )
     *     )
     * )
     */
    public function show(Activity $activity)
    {
        return ApiResponse::success(new ActivityResource($activity));
    }

    /**
     * @OA\Get(
     *     path="/api/activity/{activity}/organizations",
     *     summary="Получить огранизации по ID вида деятельности",
     *     tags={"Activities"},
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Успешно",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="organizations_ids",
     *                      type="array",
     *                      @OA\Items(type="integer", example=1)
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Не найдено",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Organizations not found")
     *         )
     *     )
     * )
     */
    public function getOrganizations(Activity $activity)
    {
        return ApiResponse::success([
            'organizations_ids' => $this->activityService->getOrganizations($activity),
        ]);
    }
    /**
     * @OA\Put(
     *     path="/api/activity/{activity}",
     *     summary="Обновить вид деятельности",
     *     tags={"Activities"},
     *     @OA\Parameter(
     *          name="activity",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="name", type="string", example="Новое название"),
     *             @OA\Property(property="parent_id", type="integer", example=2),
     *             @OA\Property(property="is_category", type="boolean", example=false)
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
