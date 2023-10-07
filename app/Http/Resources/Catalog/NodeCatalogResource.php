<?php

namespace App\Http\Resources\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NodeCatalogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'section' => $this->section,
            'level' => $this->level,
            'count_sections' => $this->count_sections,
            'count_products' => $this->count_products,
            'icon' => $this->icon,
            'image' => $this->image,
            'sort' => $this->sort,
            'lazy' => $this->lazy,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
