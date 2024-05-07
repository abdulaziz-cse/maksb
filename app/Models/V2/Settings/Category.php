<?php

namespace App\Models\V2\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    protected $casts = [
        'created_at' => 'date',
    ];

    public function group()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childern()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->childern()->with('childrenRecursive');
    }
}