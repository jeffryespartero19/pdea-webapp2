<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugType extends Model
{
    public $timestamps = true;

    protected $table = 'drug_type';

    protected $fillable = [
        'name', 'description', 'sub_category', 'unit_measurement', 'status'
    ];
}

