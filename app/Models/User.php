<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed $master
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public bool $isMaster = false;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected array $protected = [];

    /**
     * @return bool
     */
    public function isMaster(): bool
    {
        return $this->master;
    }

    /**
     * @return HasMany
     */
    public function transactions(): hasMany
    {
        return $this->hasMany(Transaction::class, 'bearbeiter', 'id');
    }

    /**
     * @return HasMany
     */
    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class, 'bearbeiter_id');
    }
}
