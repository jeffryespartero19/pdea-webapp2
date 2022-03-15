<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    public $timestamps = true;

    protected $table = 'evidence';

    protected $fillable = [
        'name', 'description', 'evidence_type_id', 'unit', 'status'
    ];
}
