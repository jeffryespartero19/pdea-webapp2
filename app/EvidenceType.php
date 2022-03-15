<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidenceType extends Model
{
    public $timestamps = true;

    protected $table = 'evidence_type';

    protected $fillable = [
        'name', 'description', 'category', 'status'
    ];
}
