<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'phone',
        'code',
        'action',
        'created_at',
        'user_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}