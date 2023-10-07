<?php

namespace App\Repositories\Api\Catalog;

use App\Repositories\CoreRepository;
use App\Models\Catalog as Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CatalogRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
    /**
     * @param $request
     * @return Model|array
     */
    public function createNodeCatalog($request): Model|array
    {
        $result = [];

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
     * @param $request
     * @return Collection|array
     */
    public function getNodesCatalog($request): Collection|array
    {
        $result = [];
        $level_lazy = [];

        try {
            $result = $this->startConditions()
                ->where('parent_id', '=', $request->id)
                ->where('level', '=', $request->level + 1)
                ->orderBy('sort', 'asc')
                ->get();

            $lazy = $this->startConditions()
                ->select(DB::raw('parent_id, count(id) as level_count'))
                ->groupBy('parent_id', 'level')
                ->having('level', '=', $request->level + 2)
                ->get();

            foreach($lazy as $m_lazy) {
                $level_lazy[$m_lazy->parent_id] = $m_lazy->level_count;
            }

            foreach ($result as $model) {
                $model->lazy = isset($level_lazy[$model->id]);
            }
        } catch (\Exception $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @param $id
     * @return Model|array
     */
    public function getNodeCatalog($id): Model|array
    {
        $result = [];

        try {
            $result = $this->startConditions()->find($id);
        } catch (\Exception $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }

    /**
     * @param $request
     * @return int|array
     */
    public function deleteNodeCatalog($request): int|array
    {
        $result = null;

        try {
            DB::beginTransaction();

            if (!$this->startConditions()->where('parent_id', $request->id)->count()) {
                $result = $this->startConditions()->destroy($request->id);
            } else {
                $result = [
                    'error' => 'Данный раздел нельзя удалить, пока есть подразделы',
                ];
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }
}
