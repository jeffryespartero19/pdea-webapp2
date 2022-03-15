<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspectStatus extends Model
{
    public $timestamps = true;

    protected $table = 'suspect_status';

    protected $fillable = [
        'name', 'status'
    ];
}
