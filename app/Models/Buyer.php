<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Buyer extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'offer',
        'message',
        'nda',
        'law',
        'consultant_type',
        'status_id',
        'user_id'
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class,'projects_buyers','buyer_id','project_id')
            ->With(['images','attachments','revenueSources','platforms','assets','type','category','country','currency','user']);
    }

    public function file()
    {
        return $this->morphOne('App\Models\Media', 'model')
            ->where('collection_name', 'files');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(BuyerType::class,'id','consultant_type');
    }

    public function status(): HasOne
    {
        return $this->hasOne(BuyerStatus::class,'id','status_id');
    }

}
