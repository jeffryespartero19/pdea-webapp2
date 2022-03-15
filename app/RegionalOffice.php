<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionalOffice extends Model
{
    public $timestamps = true;

    protected $table = 'regional_office';

    protected $fillable = [
        'name', 'ro_code', 'description', 'report_output', 'print_order', 'status'
    ];
}
