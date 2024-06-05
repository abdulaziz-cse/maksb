<?php

namespace App\Models\V2\Buyer;


use App\Models\V2\Project;
use App\Models\V2\Buyer\Buyer;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerProject extends Pivot
{
    protected $fillable = ['is_accepted'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }
}