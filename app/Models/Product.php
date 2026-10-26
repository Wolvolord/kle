<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['product_code', 'user_id', 'name', 'price', 'description'])]
class Product extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'product_code';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
