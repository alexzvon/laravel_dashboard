<?php
declare(strict_types=1);
namespace App\Services\Catalog;

use App\Repositories\Api\Catalog\CatalogRepository;

class CountSectionsCatalogService
{
    private CatalogRepository $catalogRepository;

    public function __construct()
    {
        $this->catalogRepository = app(CatalogRepository::class);
    }
    /**
     * @return int|array
     */
    public function countSections(): int|array
    {
        $arrCountSection = $this->catalogRepository->getArrSection();

        foreach ($arrCountSection as $key => $item) {
            $count = 0;

            foreach ($arrCountSection as $value) {
                if ($value['parent_id'] == $item['id']) {
                    $count++;
                }
            }

            $arrCountSection[$key]['count'] = $count;
        }

        foreach ($arrCountSection as $key => $item) {
            if ($item['count'] == 0) {
                unset($arrCountSection[$key]);
            }
        }

        $maxLevel = 0;
        $countIndex = [
            0 => [
                'count' => 0,
                'parent_id' => 0,
                'level' => 0,
            ]
        ];

        foreach ($arrCountSection as $item) {
            if ($item['level'] > $maxLevel) {
                $maxLevel = $item['level'];
            }

            $countIndex[$item['id']] = [
                'parent_id' => $item['parent_id'],
                'level' => $item['level'],
                'count' => $item['count']
            ];
        }

        for (; $maxLevel > 0; $maxLevel--) {
            foreach ($countIndex as $id => $item) {
                if ($item['level'] == $maxLevel) {
                    $countIndex[$item['parent_id']]['count'] += $item['count'];
                }
            }
        }

        return $this->catalogRepository->setArrSection($countIndex);
    }
}
