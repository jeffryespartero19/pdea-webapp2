<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreopsTarget extends Model
{
    public $timestamps = true;

    protected $table = 'preops_target';

    protected $fillable = [
        'preops_number', 'name', 'nationality_id'
    ];
}
