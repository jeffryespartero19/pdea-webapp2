<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identifier extends Model
{
    public $timestamps = true;

    protected $table = 'identifier';

    protected $fillable = [
        'name', 'status'
    ];
}
