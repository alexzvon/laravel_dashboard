<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NodesCatalogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'parent_id' => $item->parent_id,
                    'name' => $item->name,
                    'section' => $item->section,
                    'level' => $item->level,
                    'count_sections' => $item->count_sections,
                    'count_products' => $item->count_products,
                    'icon' => $item->icon,
                    'image' => $item->image,
                    'sort' => $item->sort,
                    'lazy' => $item->lazy,
                    'created_at' => $item->created_at->toDateTimeString(),
                    'updated_at' => $item->updated_at->toDateTimeString(),
                ];
            }
        )->toArray();
    }
}
