<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssuanceOfPreops extends Model
{
    public $timestamps = true;

    protected $table = 'preops_header';

    protected $fillable = [
        'preops_number',
        'region_c',
        'operating_unit_id',
        'operation_type_id',
        'coordinated_datetime',
        'duration',
        'operation_datetime',
        'validity',
        'remarks',
        'reference_number',
        'prepared_by',
        'approved_by',
        'status',
        'support_unit',
    ];
}
