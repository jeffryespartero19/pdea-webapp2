<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HIO extends Model
{
    protected $table = 'hio_type';

    protected $fillable = [
        'name', 'status'
    ];
}
