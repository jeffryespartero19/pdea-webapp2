<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseList extends Model
{
    public $timestamps = true;

    protected $table = 'case_list';

    protected $fillable = [
        'description', 'status'
    ];
}
