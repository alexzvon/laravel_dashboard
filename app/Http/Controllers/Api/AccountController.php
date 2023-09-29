<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Repositories\Api\AccountRepository;

class AccountController extends ApiBaseController
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
     * @return AccountCollection
     */
    public function getAccount(int $id): AccountCollection
    {
        return AccountCollection::make($this->accountRepository->getAccount($id));
    }

    /**
     * @param int $idPerson
     * @return AnonymousResourceCollection
     */
    public function getAccountList(int $idPerson): AnonymousResourceCollection
    {
        return AccountResource::collection($this->accountRepository->getAccountList($idPerson));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteAccount(int $id): JsonResponse
    {
        return $this->returnJsonResponse($this->accountRepository->deleteAccount($id));
    }

    /**
     * @param UpdateAccountRequest $request
     * @return JsonResponse
     */
    public function updateAccount(UpdateAccountRequest $request): JsonResponse
    {
        return $this->returnJsonResponse($this->accountRepository->updateAccount($request));
    }

//    /**
//     * @param $result
//     * @return JsonResponse
//     */
//    private function returnJsonResponse($result): JsonResponse
//    {
//        if (is_array($result)) {
//            return response()->json($result, 422);
//        } else {
//            return response()->json(['success' => $result, 200]);
//        }
//    }
}
