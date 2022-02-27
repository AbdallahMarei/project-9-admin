<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';
    protected $fillable = [
        'cat_id',
        'name',
        'brief',
        'description',
        'image',
        'stock',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }
}
