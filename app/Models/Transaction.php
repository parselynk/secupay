<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    public $table = 'transaktion_transaktionen';
    public $hidden = [];
    public $primaryKey = 'trans_id';

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bearbeiter');
    }

    /**
     * Get all the materFlagBits for the transaction.
     */
    public function flagBits(): HasMany
    {
        return $this->hasMany(MasterFlagBit::class, 'bearbeiter_id', 'bearbeiter');
    }
}
