<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $master
 */
class ApiKey extends Model
{
    use HasFactory;

    public $table = 'api_apikey';
    public $primaryKey = 'apikey_id';
    public $timestamps = false;
    public $hidden = [];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected array $protected = [];

    public $casts = [
        'timestamp' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return HasOne
     */
    public function periodSpecification(): HasOne
    {
        return $this->hasOne(PeriodSpecification::class, 'zeitraum_id','zeitraum_id');
    }
}
