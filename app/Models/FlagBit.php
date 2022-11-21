<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlagBit extends Model
{
    use HasFactory;

    public $table = 'vorgaben_flagbit';
    public $primaryKey = 'flagbit_id';
    public $hidden = [];
}
