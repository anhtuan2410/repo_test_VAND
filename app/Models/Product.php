<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'price'
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'product_store');
    }

    public function getRule() {
        return [
            'name' => 'required|string',
            'price' => 'required'
        ];
    }
}
