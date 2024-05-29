<?php

namespace App\Models\V2\General;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\V2\Settings\PredefinedValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, SearchableTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'status_id',
        'email',
        'message',
        'phone',
    ];

    /**
     * SearchableTrait attributes
     *
     * @return string[]
     */
    public array $searchable = [
        'status.id',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(PredefinedValue::class, 'status_id');
    }
}