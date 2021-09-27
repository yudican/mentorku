<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivePlan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_start_date', 'plan_end_date', 'plan_status', 'plan_id', 'user_id'];

    protected $dates = ['plan_start_date', 'plan_end_date'];

    /**
     * Get the plan that owns the ActivePlan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the user that owns the ActivePlan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
