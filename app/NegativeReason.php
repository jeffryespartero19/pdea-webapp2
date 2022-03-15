<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NegativeReason extends Model
{
    public $timestamps = true;

    protected $table = 'negative_reason';

    protected $fillable = [
        'name', 'description', 'status'
    ];
}
