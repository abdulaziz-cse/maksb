<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerStatus extends Model
{
    use HasFactory;

    protected $table = 'buyers_status';
    public $timestamps = false;

}
