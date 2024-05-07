<?php

namespace App\Models\V2\Settings;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PredefinedValue extends Model
{
    use HasFactory, SoftDeletes, SearchableTrait;

    protected $fillable = ['name', 'parent_id', 'slug'];

    public function group()
    {
        return $this->belongsTo(PredefinedValue::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}