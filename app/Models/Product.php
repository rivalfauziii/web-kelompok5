<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'barcode',
        'stock',
        'price',
        'image'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}