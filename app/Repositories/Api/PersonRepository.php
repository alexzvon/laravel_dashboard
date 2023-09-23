<?php

namespace App\Repositories\Api;

use App\Repositories\CoreRepository;
use App\Models\Person as Model;

class PersonRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Model::class;
    }

    public function createPerson($request): Model | array
    {
        try {
            return $this->startConditions()->create($request->all());
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }


}
