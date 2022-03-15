<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    public $timestamps = true;

    protected $table = 'tbluserlevel';

    protected $fillable = [
        'name', 'description', 'status'
    ];
}
