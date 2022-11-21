<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodSpecification extends Model
{
    use HasFactory;

    public $table = 'vorgaben_zeitraum';
    public $primaryKey = 'zeitraum_id';
    public $timestamps = false;
    public $hidden = [];

    public $casts = [
        'von' => 'datetime:Y-m-d H:i:s',
        'bis' => 'datetime:Y-m-d H:i:s',
    ];
}
