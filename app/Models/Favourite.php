<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory, SearchableTrait;

    protected $fillable = [
        'user_id',
        'project_id',
    ];

    public $timestamps = false;

    /**
     * SearchableTrait attributes
     *
     * @return string[]
     */
    public array $searchable = [
        'user.id', 'project.id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
