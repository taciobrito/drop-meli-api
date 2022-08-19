<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'title',
        'description',
        'condition',
        'available_quantity',
        'pictures',
        'category_id',
        'category',
        'price',
        'sold_quantity',
        'currency_id'
    ];
}
