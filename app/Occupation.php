<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    public $timestamps = true;

    protected $table = 'occupation';

    protected $fillable = [
        'name', 'status'
    ];
}
