<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerType extends Model
{
    use HasFactory;

    protected $table = 'buyers_types';
    public $timestamps = false;

}
