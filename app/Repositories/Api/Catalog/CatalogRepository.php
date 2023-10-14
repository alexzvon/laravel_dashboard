<?php

namespace App\Repositories\Api\Catalog;

use App\Repositories\CoreRepository;
use App\Models\Catalog as Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CatalogRepository extends CoreRepository
{
    private array $arrCount = [];

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
    public function setNodeCatalog($request): int | array
    {
        $result = [];

        try {
            DB::beginTransaction();

            $setFields = [
                'section' => $request->section,
                'name' => $request->name,
                'image' => $request->image ?? '',
                'icon' => $request->icon ?? '',
                'sort' => $request->sort,
            ];

            $result = $this->startConditions()
                    ->whereId($request->id)
                    ->update($setFields);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $result = [
                'error' => $e->getMessage()
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

            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }
    /**
     * @return array
     */
    public function getArrSection(): array
    {
        return $this->startConditions()
            ->select(['id', 'parent_id', 'level'])
            ->get()
            ->toArray();
    }
    /**
     * @param array $countIndex
     * @return int|array
     */
    public function setArrSection(array $countIndex): int|array
    {
        $result = 0;

        try {
            DB::beginTransaction();

            foreach ($countIndex as $id => $item) {
                $result += $this->startConditions()
                    ->whereId($id)
                    ->update(['count_sections' => $item['count']]);
            }

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
