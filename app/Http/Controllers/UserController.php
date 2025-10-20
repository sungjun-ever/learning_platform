<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    )
    {
    }

    /**
     * 사용자 정보 가져오기
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $user = $this->userService->getUserUseUuid($uuid);

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user)
        ]);
    }

    /**
     * 사용자 생성
     * @param StoreUserRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $uuid = $this->userService->createUser($request->validationData());

        return response()->json([
            'status' => 'success',
            'data' => [
                'uid' => $uuid,
            ]
        ]);
    }

    /**
     * 사용자 정보 수정
     * @param UpdateUserRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $data = $request->validationData();

        $uuid = $this->userService->updateUser($data['uuid'], $data);

        return response()->json([
            'status' => 'success',
            'data' => [
                'uid' => $uuid
            ],
        ]);
    }
}
