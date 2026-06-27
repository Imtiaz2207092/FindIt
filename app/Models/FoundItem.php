<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundItem extends Model
{
    use HasFactory;

    protected $table = 'found_items';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image',
        'location',
        'found_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'found_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'found_id', 'id');
    }
}
