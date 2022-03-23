<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    public $timestamps = true;

    protected $table = 'memo';

    protected $fillable = [
        'name', 'status', 'filenames'
    ];
}
