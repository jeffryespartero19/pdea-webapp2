<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    public $timestamps = true;

    protected $table = 'packaging';

    protected $fillable = [
        'name', 'status'
    ];
}
