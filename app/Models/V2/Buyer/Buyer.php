<?php

namespace App\Models\V2\Buyer;


use App\Models\V2\Project;
use App\Models\V2\User\User;
use App\Traits\SearchableTrait;
use Spatie\MediaLibrary\HasMedia;
use App\Models\V2\Buyer\BuyerProject;
use Illuminate\Database\Eloquent\Model;
use App\Models\V2\Settings\PredefinedValue;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Buyer extends Model implements HasMedia
{
    use HasFactory, SearchableTrait, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'offer',
        'message',
        'nda',
        'law',
        'consultant_type_id',
        'status_id',
        'user_id',
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
        return $this->belongsToMany(Project::class)
            ->withPivot('is_accepted')
            ->using(BuyerProject::class);
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

    public function type(): BelongsTo
    {
        return $this->belongsTo(PredefinedValue::class, 'consultant_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PredefinedValue::class, 'status_id');
    }
}