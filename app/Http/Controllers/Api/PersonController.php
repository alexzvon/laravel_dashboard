<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\CreatePersonRequest;
use App\Http\Resources\PersonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Repositories\Api\PersonRepository;

class PersonController extends Controller
{
    private PersonRepository $personRepository;

    public function __construct()
    {
        $this->personRepository = app(PersonRepository::class);
    }

    /**
     * @param CreatePersonRequest $request
     * @return JsonResponse
     */
    public function createPerson(CreatePersonRequest $request): JsonResponse
    {
        $result = $this->personRepository->createPerson($request);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return PersonResource::make($result);
        }
    }
}
