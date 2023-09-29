<?php

namespace App\Http\Controllers\Api\Additionally;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Site\PrivacyPolicyRequest;
use App\Repositories\Api\Site\PrivacyPolicyRepository;
use Illuminate\Http\JsonResponse;

class PrivacyPolicyController extends ApiBaseController
{
    private PrivacyPolicyRepository $privacyPolicyRepository;

    public function __construct()
    {
        $this->privacyPolicyRepository = app(PrivacyPolicyRepository::class);
    }

    /**
     * @return JsonResponse
     */
    public function getPrivacyPolicy(): JsonResponse
    {
        return $this->returnJsonResponse($this->privacyPolicyRepository->getPrivacyPolicy());
    }

    /**
     * @param PrivacyPolicyRequest $request
     * @return JsonResponse
     */
    public function savePrivacyPolicy(PrivacyPolicyRequest $request): JsonResponse
    {
        return $this->returnJsonResponse($this->privacyPolicyRepository->savePrivacyPolicy($request));
    }
}
