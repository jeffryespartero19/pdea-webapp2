<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    public $timestamps = true;

    protected $table = 'barangay';

    protected $fillable = [
        'barangay_c', 'barangay_m', 'city_c', 'status',
    ];
}
