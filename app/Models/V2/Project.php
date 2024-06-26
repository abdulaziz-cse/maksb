<?php

namespace App\Models\V2;

use App\Models\Asset;

use App\Constants\App;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Platform;
use App\Models\Favourite;
use App\Models\V2\User\User;
use App\Models\RevenueSource;
use App\Models\V2\Buyer\Buyer;
use App\Traits\SearchableTrait;
use App\Enums\Buyer\BuyerStatus;
use Spatie\MediaLibrary\HasMedia;
use App\Models\V2\Settings\Region;
use Illuminate\Database\Eloquent\Model;
use App\Models\V2\Settings\PredefinedValue;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SearchableTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'type_id',
        'website',
        'establishment_date',
        'country_id',
        'other_platform',
        'currency_id',
        'category_id',
        'yearly',
        'other_assets',
        'is_supported',
        'support',
        'email_subscribers',
        'video_url',
        'price',
        'package_id',
        'description',
        'short_description',
        'expenses',
        'social_media',
        'billing_info',
        'incoming',
        'cost',
        'revenue',
        'status_id',
        'buyer_id',
    ];

    protected $casts = [
        'incoming' => 'array',
        'cost' => 'array',
        'revenue' => 'array',
        'expenses' => 'array',
        'social_media' => 'array',
        'billing_info' => 'array',
        'establishment_date' => 'date',
    ];

    protected $appends = [
        'isFavorite',
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

    public function revenueSources(): BelongsToMany
    {
        return $this->belongsToMany(RevenueSource::class);
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class);
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PredefinedValue::class, 'type_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'country_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
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

    public function offers(): HasMany
    {
        return $this->hasMany(Buyer::class);
    }

    public function currentUserFavorite()
    {
        return $this->hasMany(Favourite::class, 'project_id', 'id')
            ->where('favourites.user_id', auth(App::API_GUARD)->id());
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PredefinedValue::class, 'status_id');
    }

    public function getIsFavoriteAttribute()
    {
        return $this->currentUserFavorite()->count();
    }

    public function getOfferCountAttribute()
    {
        return $this->offers()->count();
    }

    public function getOfferPendingCountAttribute()
    {
        return $this->offers()
            ->whereHas('status', function ($query) {
                $query->where('slug', BuyerStatus::PENDING->value);
            })
            ->count();
    }

    public function getOfferRejectedCountAttribute()
    {
        return $this->offers()
            ->whereHas('status', function ($query) {
                $query->where('slug', BuyerStatus::REJECTED->value);
            })
            ->count();
    }
}
