<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['confirm_date'];

    /**
     * Get the transaction that owns the ConfirmPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
