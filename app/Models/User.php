<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $primaryKey = 'id';

    protected $casts = [
        'password' => 'hashed',
    ];

    public function supportsRememberToken(): bool
    {
        try {
            return Schema::connection($this->getConnectionName())
                ->hasColumn($this->getTable(), 'remember_token');
        } catch (\Throwable) {
            return false;
        }
    }

    public function getRememberTokenName()
    {
        return $this->supportsRememberToken() ? 'remember_token' : null;
    }

    public function setRememberToken($value)
    {
        if (! $this->supportsRememberToken()) {
            return;
        }

        $this->attributes[$this->getRememberTokenName()] = $value;
    }

    public function getRememberToken()
    {
        if (! $this->supportsRememberToken()) {
            return null;
        }

        return $this->getAttribute($this->getRememberTokenName());
    }

    public function lostItems()
    {
        return $this->hasMany(LostItem::class, 'user_id');
    }

    public function foundItems()
    {
        return $this->hasMany(FoundItem::class, 'user_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
