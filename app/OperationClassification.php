<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationClassification extends Model
{
    public $timestamps = true;

    protected $table = 'operation_classification';

    protected $fillable = [
        'name', 'status',
    ];
}
