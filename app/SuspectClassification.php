<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspectClassification extends Model
{
    public $timestamps = true;

    protected $table = 'suspect_classification';

    protected $fillable = [
        'name', 'description', 'reason', 'status'
    ];
}

