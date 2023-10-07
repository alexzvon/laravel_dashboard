<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'catalog';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'parent_id',
        'section',
        'level',
        'count_sections',
        'count_products',
        'name',
        'image',
        'icon',
        'sort',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'parent_id' => 0,
        'section' => true,
        'level' => 0,
        'count_sections' => 0,
        'count_products' => 0,
        'image' => '',
        'icon' => '',
        'sort' => 100,
    ];
}
