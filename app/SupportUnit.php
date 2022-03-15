<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportUnit extends Model
{
    public $timestamps = true;

    protected $table = 'support_unit';

    protected $fillable = [
        'name', 'status'
    ];
}
