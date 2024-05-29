<?php

namespace App\Models\V2\Auth;

use App\Enums\Auth\VerificationAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\V2\Auth\SmsProvider\Models\Enums\TwilioStatus;

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
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'action' => VerificationAction::class,
        'status' => TwilioStatus::class,
    ];
}
