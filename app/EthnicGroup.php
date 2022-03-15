<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EthnicGroup extends Model
{
    public $timestamps = true;

    protected $table = 'ethnic_group';

    protected $fillable = [
        'name', 'status'
    ];
}
