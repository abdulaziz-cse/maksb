<?php

namespace App\Models\V2\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->childs()->with('childrenRecursive');
    }
}
