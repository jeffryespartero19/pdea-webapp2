<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationalAttainment extends Model
{
    public $timestamps = true;

    protected $table = 'educational_attainment';

    protected $fillable = [
        'name', 'status'
    ];
}
