<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_title', 'plan_price', 'plan_duration', 'plan_max_mentor', 'plan_max_type'];

    protected $dates = [];

    /**
     * Get all of the transactions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get all of the activePlan for the Plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activePlan()
    {
        return $this->hasMany(ActivePlan::class);
    }
}
