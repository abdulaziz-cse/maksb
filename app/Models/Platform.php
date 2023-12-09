<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Platform extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('platforms')->singleFile();
    }

    public $timestamps = false;

    public function logo()
    {
        return $this->morphOne('App\Models\Media', 'model')
            ->where('collection_name', 'platforms');
    }


}
