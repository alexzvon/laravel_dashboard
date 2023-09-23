<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
//use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use App\Repositories\Api\AccountRepository;

class AccountController extends Controller
{
    private AccountRepository $accountRepository;

    public function __construct()
    {
        $this->accountRepository = app(AccountRepository::class);
    }

    /**
     * @param CreateAccountRequest $request
     * @return JsonResponse|AccountResource
     */
    public function createAccount(CreateAccountRequest $request): JsonResponse | AccountResource
    {
        $result = $this->accountRepository->createAccount($request);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return AccountResource::make($result);
        }
    }

    /**
     * @param int $id
     * @return AccountResource
     */
    public function getAccount(int $id): AccountResource
    {
        return AccountResource::make($this->accountRepository->getAccount($id));
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAccountList(): AnonymousResourceCollection
    {
        return AccountResource::collection($this->accountRepository->getAccountList());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteUser(int $id): JsonResponse
    {
        $result = $this->accountRepository->deleteUser($id);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return response()->json(['success' => $result], 200);
        }
    }

    /**
     * @param UpdateAccountRequest $request
     * @return AccountResource
     */
    public function updateUser(UpdateAccountRequest $request): AccountResource
    {
        return AccountResource::make($this->accountRepository->updateUser($request));
    }
}
