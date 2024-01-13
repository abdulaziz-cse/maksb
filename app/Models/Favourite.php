<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'project_id',
    ];

    public $timestamps = false;


}
