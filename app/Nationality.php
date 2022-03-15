<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    public $timestamps = true;

    protected $table = 'nationality';

    protected $fillable = [
        'name', 'status'
    ];
}
