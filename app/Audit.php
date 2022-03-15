<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'module', 'menu', 'activity', 'description'
    ];
}
