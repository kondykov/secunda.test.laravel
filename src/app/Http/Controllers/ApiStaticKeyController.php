<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiStaticKeyRequest;
use App\Http\Resources\ApiStaticKeyResource;
use App\Models\ApiStaticKey;
use App\Utils\ApiResponse;
use OpenApi\Annotations as OA;

class ApiStaticKeyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/identity",
     *     summary="Получить список всех статических API ключей",
     *     tags={"Identity"},
     *     security={{"apiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список API ключей успешно получен",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ApiStaticKey")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не авторизован"
     *     )
     * )
     */
    public function index()
    {
        return ApiResponse::success(ApiStaticKeyResource::collection(ApiStaticKey::all()));
    }

    /**
     * @OA\Post(
     *     path="/api/identity",
     *     summary="Создать новый статический API ключ",
     *     tags={"Identity"},
     *     security={{"apiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ApiStaticKeyCreate")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="API ключ успешно создан",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ApiStaticKey")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не авторизован"
     *     )
     * )
     */
    public function store(ApiStaticKeyRequest $request)
    {
        return ApiResponse::success(new ApiStaticKeyResource(ApiStaticKey::create($request->validated())));
    }

    /**
     * @OA\Get(
     *     path="/api/identity/{key}",
     *     summary="Получить статический API ключ по ID",
     *     tags={"Identity"},
     *     security={{"apiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="apiStaticKey",
     *         in="path",
     *         required=true,
     *         description="ID API ключа",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="API ключ успешно получен",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ApiStaticKey")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="API ключ не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Api static key not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не авторизован"
     *     )
     * )
     */
    public function show(ApiStaticKey $apiStaticKey)
    {
        return ApiResponse::success(new ApiStaticKeyResource($apiStaticKey));
    }

    /**
     * @OA\Put(
     *     path="/api/identity/{key}",
     *     summary="Обновить статический API ключ",
     *     tags={"Identity"},
     *     security={{"apiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="apiStaticKey",
     *         in="path",
     *         required=true,
     *         description="ID API ключа",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ApiStaticKeyUpdate")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="API ключ успешно обновлен",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/ApiStaticKey")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="API ключ не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Api static key not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не авторизован"
     *     )
     * )
     */
    public function update(ApiStaticKeyRequest $request, ApiStaticKey $apiStaticKey)
    {
        $apiStaticKey->update($request->validated());

        return ApiResponse::success(new ApiStaticKeyResource($apiStaticKey));
    }

    /**
     * @OA\Delete(
     *     path="/api/identity/{key}",
     *     summary="Удалить статический API ключ",
     *     tags={"Identity"},
     *     security={{"apiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="apiStaticKey",
     *         in="path",
     *         required=true,
     *         description="ID API ключа",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="API ключ успешно удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="API ключ не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Api static key not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не авторизован"
     *     )
     * )
     */
    public function delete(ApiStaticKey $apiStaticKey)
    {
        $apiStaticKey->delete();

        return response()->json(status: 204);
    }
}
