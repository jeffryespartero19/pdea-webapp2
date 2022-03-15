<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspectCategory extends Model
{
    public $timestamps = true;

    protected $table = 'suspect_category';

    protected $fillable = [
        'name', 'status'
    ];
}
