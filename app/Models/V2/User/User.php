<?php

namespace App\Models\V2\User;

use App\Models\V2\Project;
use App\Traits\Messageable;
use App\Models\V2\Buyer\Buyer;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\V2\Settings\PredefinedValue;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Messageable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'type_id',
        'password',
        'about',
        'purchase_purpose',
        'budget',
        'favorite_value',
        'profession',
        'owner_of',
        'portfolio',
        'website',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function photo()
    {
        return $this->morphOne('App\Models\Media', 'model')
            ->where('collection_name', 'avatars');
    }

    public function isAdmin()
    {
        return false;
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function buyers(): HasMany
    {
        return $this->hasMany(Buyer::class);
    }

    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'favourites', 'user_id', 'project_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PredefinedValue::class, 'type_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
