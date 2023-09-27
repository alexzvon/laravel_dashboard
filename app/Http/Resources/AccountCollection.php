<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountCollection extends ResourceCollection
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
                    'person_id' => $item->person_id,
                    'fio' => $item->person->fio,
                    'phone' => $item->person->phone,
                    'email' => $item->email,
                    'role' => $item->role,
                    'is_active' => $item->is_active,
                    'created_at' => $item->created_at->toDateTimeString(),
                    'updated_at' => $item->updated_at->toDateTimeString(),
                ];
            })->toArray();

//        return [
//            'data' => $this->collection->map(function ($item) {
//                return [
//                    'id' => $item->id,
//                    'person_id' => $item->person_id,
//                    'fio' => $item->person->fio,
//                    'email' => $item->email,
//                    'role' => $item->role,
//                    'is_active' => $item->is_active,
//                    'created_at' => $item->created_at,
//                    'updated_at' => $item->updated_at,
//                ];
//            })
//        ];
    }
}

