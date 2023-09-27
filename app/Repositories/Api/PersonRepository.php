<?php

namespace App\Repositories\Api;

use App\Repositories\CoreRepository;
use App\Models\Person as Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param $request
     * @return Model|array
     */
    public function createPerson($request): Model | array
    {
        $result = null;

        try {
            DB::beginTransaction();
            $result = $this->startConditions()->create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @return Collection
     */
    public function getPersonsList(): Collection
    {
        return $this->startConditions()->orderBy('id', 'asc')->get();
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function getPerson($id) : Model | null
    {
        return $this->startConditions()->find($id);
    }

    /**
     * @param $request
     * @return int|array
     */
    public function updatePerson($request): int|array
    {
        $result = null;

        try {
            $updateValue = [
                'fio' => $request->fio,
                'sex' => $request->sex,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
            ];

            if ($request->address) {
                $updateValue['address'] = $request->address;
            }

            if ($request->description) {
                $updateValue['description'] = $request->description;
            }

            if ($request->avatar) {
                $updateValue['avatar'] = $request->avatar;
            }

            DB::beginTransaction();

            $result = $this->startConditions()
                ->whereId($request->id)
                ->update($updateValue);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @param $id
     * @return int|array
     */
    public function deletePerson($id): int|array
    {
        $result = null;

        try {
            DB::beginTransaction();
            $result = $this->startConditions()->destroy($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }
}
