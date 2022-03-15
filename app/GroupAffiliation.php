<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupAffiliation extends Model
{
    public $timestamps = true;

    protected $table = 'group_affiliation';

    protected $fillable = [
        'name', 'status'
    ];
}
