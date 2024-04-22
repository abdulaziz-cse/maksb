<?php

namespace App\Models;

use App\Models\User;
use App\Traits\SearchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends Model implements HasMedia
{
    use HasFactory, SearchableTrait, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'offer',
        'message',
        'nda',
        'law',
        'consultant_type',
        'status_id',
        'user_id'
    ];

    /**
     * SearchableTrait attributes
     *
     * @return string[]
     */
    public array $searchable = [
        'user.id',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'projects_buyers', 'buyer_id', 'project_id')
            ->With(['images', 'attachments', 'revenueSources', 'platforms', 'assets', 'type', 'category', 'country', 'currency', 'user']);
    }

    public function file()
    {
        return $this->morphOne('App\Models\Media', 'model')
            ->where('collection_name', 'files');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(BuyerType::class, 'id', 'consultant_type');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(BuyerStatus::class);
    }
}
