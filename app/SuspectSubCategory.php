<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspectSubCategory extends Model
{
    public $timestamps = true;

    protected $table = 'suspect_sub_category';

    protected $fillable = [
        'name', 'suspect_category_id', 'status'
    ];
}
