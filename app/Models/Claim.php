<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $table = 'claims';
    protected $primaryKey = 'claim_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'lost_id',
        'found_id',
        'proof_details',
        'status',
        'claim_date',
    ];

    protected function casts(): array
    {
        return [
            'claim_date' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lostItem()
    {
        return $this->belongsTo(LostItem::class, 'lost_id', 'id');
    }

    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class, 'found_id', 'id');
    }
}
