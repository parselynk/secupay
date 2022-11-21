<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFlagBit extends Model
{
    use HasFactory;

    public $table = 'stamd_flagbit_ref';
    public $primaryKey = 'flagbit_ref_id';
    public $hidden = [];
    public $guarderd = [];
    public $timestamps = false;
    public $casts = [
        'timestamp' => 'datetime:Y-m-d H:i:s',
    ];
}
