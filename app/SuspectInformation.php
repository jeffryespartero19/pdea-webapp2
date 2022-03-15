<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuspectInformation extends Model
{
    public $timestamps = true;

    protected $table = 'suspect_information';

    protected $fillable = [
        'suspect_number',
        'lastname',
        'firstname',
        'middlename',
        'alias',
        'gender',+
        'birthdate',
        'birthplace',
        'nationality_id',
        'civil_status_id',
        'religion_id',
        'educational_attainment_id',
        'ethnic_group_id',
        'occupation_id',
        'monthly_income',
        'region_c',
        'province_c',
        'city_c',
        'barangay_c',
        'street',
        'identifier_id',
        'suspect_classification_id',
        'group_affiliation_id',
        'drug_group',
        'remarks',
        'status',
        'photo',
        'operation_classification_id',
        'operation_date',
        'operation_region',
        'operating_unit_id',
    ];
}
