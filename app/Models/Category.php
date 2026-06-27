<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
    ];

    public function lostItems()
    {
        return $this->hasMany(LostItem::class, 'category_id', 'id');
    }

    public function foundItems()
    {
        return $this->hasMany(FoundItem::class, 'category_id', 'id');
    }
}
