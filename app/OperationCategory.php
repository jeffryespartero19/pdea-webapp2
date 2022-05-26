<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationCategory extends Model
{
    public $timestamps = true;

    protected $table = 'operation_category';

    protected $fillable = [
        'operation_classification_id', 'name', 'status'
    ];
}
