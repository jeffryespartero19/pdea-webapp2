<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    public $timestamps = true;

    protected $table = 'operation_type';

    protected $fillable = [
        'name', 'status', 'operation_classification_id', 'is_warrant', 'is_testbuy'
    ];
}
