<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreopsTeam extends Model
{
    public $timestamps = true;

    protected $table = 'preops_target';

    protected $fillable = [
        'preops_number', 'name', 'position', 'contact',
    ];
}
