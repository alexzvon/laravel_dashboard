<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Person\CreatePersonRequest;
use App\Http\Requests\Person\UpdatePersonRequest;
use App\Http\Resources\PersonResource;
use Illuminate\Http\JsonResponse;

use App\Repositories\Api\PersonRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PersonController extends ApiBaseController
{
    private PersonRepository $personRepository;

    public function __construct()
    {
        $this->personRepository = app(PersonRepository::class);
    }

    /**
     * @param CreatePersonRequest $request
     * @return JsonResponse|PersonResource
     */
    public function createPerson(CreatePersonRequest $request): JsonResponse | PersonResource
    {
        $result = $this->personRepository->createPerson($request);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return PersonResource::make($result);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getPersonsList(): AnonymousResourceCollection
    {
        return PersonResource::collection($this->personRepository->getPersonsList());
    }

    /**
     * @param int $id
     * @return PersonResource
     */
    public function getPerson(int $id): PersonResource
    {
        return PersonResource::make($this->personRepository->getPerson($id));
    }

    /**
     * @param UpdatePersonRequest $person
     * @return JsonResponse
     */
    public function updatePerson(UpdatePersonRequest $person): JsonResponse
    {
        return $this->returnJsonResponse($this->personRepository->updatePerson($person));
    }

    public function deletePerson(int $id): JsonResponse
    {
        return $this->returnJsonResponse($this->personRepository->deletePerson($id));
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
