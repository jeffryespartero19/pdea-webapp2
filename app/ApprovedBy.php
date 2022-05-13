<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovedBy extends Model
{
    public $timestamps = true;

    protected $table = 'approved_by';

    protected $fillable = [
        'name', 'ro_code', 'officer_position_id', 'status',
    ];
}
