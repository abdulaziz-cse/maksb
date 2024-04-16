<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Spatie\MediaLibrary\HasMedia;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SearchableTrait;

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
        'user.id', 'category.id',
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

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function buyers(): BelongsToMany
    {
        return $this->belongsToMany(Buyer::class, 'projects_buyers', 'project_id', 'buyer_id');
    }

    public function currentUserFavorite()
    {
        return $this->hasMany(Favourite::class, 'project_id', 'id')->where('favourites.user_id', auth('sanctum')->id());
    }
}
