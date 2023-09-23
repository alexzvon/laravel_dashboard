<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use App\Repositories\Api\UserRepository;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        $result = $this->userRepository->createUser($request);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return UserResource::make($result);
        }
    }

    /**
     * @param int $id
     * @return UserResource
     */
    public function getUser(int $id): UserResource
    {
        return UserResource::make($this->userRepository->getUser($id));
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getUsersList(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userRepository->getUsersList());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteUser(int $id): JsonResponse
    {
        $result = $this->userRepository->deleteUser($id);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return response()->json([ 'success' => $result ], 200);
        }
    }

    /**
     * @param UpdateUserRequest $request
     * @return UserResource
     */
    public function updateUser(UpdateUserRequest $request): UserResource
    {
        return UserResource::make($this->userRepository->updateUser($request));
    }
}
