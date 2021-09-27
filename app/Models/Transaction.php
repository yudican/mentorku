<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['transaction_total_price', 'transaction_unique_id', 'transaction_date', 'transaction_expired_date', 'transaction_struct_upload', 'transaction_note', 'transaction_status', 'bank_id', 'plan_id', 'user_id'];

    protected $dates = ['transaction_date', 'transaction_expired_date'];

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bank that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get the plan that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get all of the confirmPayment for the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function confirmPayment()
    {
        return $this->hasMany(ConfirmPayment::class);
    }
}
