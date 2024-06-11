<?php

namespace App\Traits;


trait MediaTrait
{
    protected function uploadImage($model, $image, $collectionName = 'images'): void
    {
        $model->addMedia($image)->toMediaCollection($collectionName);
    }

    protected function deleteImage($model): void
    {
        $model->media()->delete();
    }
}