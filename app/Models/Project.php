<?php

namespace App\Models;

use App\Constants\App;
use App\Traits\SearchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SearchableTrait, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'incoming' => 'array',
        'cost' => 'array',
        'revenue' => 'array',
        'expenses' => 'array',
        'social_media' => 'array',
        'billing_info' => 'array'
    ];

    protected $appends = [
        'isFavorite'
    ];

    /**
     * SearchableTrait attributes
     *
     * @return string[]
     */
    public array $searchable = [
        'user.id',
        'category.id',
    ];

    public function getIsFavoriteAttribute()
    {
        $relations = $this->getRelations();
        if (isset($relations['currentUserFavorite']))
            return count($relations['currentUserFavorite']);
        else
            return 0;
    }

    public function revenueSources(): BelongsToMany
    {
        return $this->belongsToMany(RevenueSource::class, 'projects_revenue_sources', 'project_id', 'revenue_source_id');
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'projects_platforms', 'project_id', 'platform_id');
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'projects_assets', 'project_id', 'asset_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany('App\Models\Media', 'model')
            ->where('collection_name', 'images');
    }

    public function attachments()
    {
        return $this->morphMany('App\Models\Media', 'model')
            ->where('collection_name', 'attachments');
    }

    public function buyers(): BelongsToMany
    {
        return $this->belongsToMany(Buyer::class);
    }

    public function currentUserFavorite()
    {
        return $this->hasMany(Favourite::class, 'project_id', 'id')
            ->where('favourites.user_id', auth(App::API_GUARD)->id());
    }
}
