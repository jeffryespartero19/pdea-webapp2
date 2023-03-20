<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrugManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data1 = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_management as d', 'a.id', '=', 'd.suspect_id')
            ->leftjoin('region as f', 'b.region_c', '=', 'f.region_c')
            ->leftjoin('province as g', 'b.province_c', '=', 'g.province_c')
            ->leftjoin('city as h', 'b.city_c', '=', 'h.city_c')
            ->leftjoin('barangay as i', 'b.barangay_c', '=', 'i.barangay_c')
            ->leftjoin('operating_unit as j', 'b.operating_unit_id', '=', 'j.id')
            ->leftjoin('operation_type as k', 'b.operation_type_id', '=', 'k.id')
            ->leftjoin('suspect_classification as l', 'a.suspect_classification_id', '=', 'l.id')
            ->leftjoin('suspect_category as m', 'a.suspect_category_id', '=', 'm.id')
            ->leftjoin('suspect_status as n', 'a.suspect_status_id', '=', 'n.id')
            ->leftjoin('spot_report_case as o', 'a.suspect_number', '=', 'o.suspect_number')
            ->leftjoin('case_list as p', 'o.case_id', '=', 'p.id')

            ->select(
                'a.id',
                'b.preops_number',
                'b.spot_report_number',
                'b.operation_datetime',
                'f.region_m',
                'g.province_m',
                'h.city_m',
                'i.barangay_m',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'd.ndis_id',
                'd.listed',
                'd.remarks',
                'j.name as operating_unit',
                'k.name as operation_type',
                'l.name as suspect_classification',
                'm.name as suspect_category',
                'n.name as status',
                'b.street',
                'p.description as case',
                'o.docket_number',
                'o.case_status',

            )
            ->where('b.operation_lvl', 1)
            ->orderby('a.lastname', 'asc')
            ->paginate(20);

        return view('drug_management.drug_management_list', compact('data1'));
    }

    public function search_drug_management_list(Request $request)
    {
        $param = $request->get('param');

        $data1 = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_management as d', 'a.id', '=', 'd.suspect_id')
            ->leftjoin('region as f', 'b.region_c', '=', 'f.region_c')
            ->leftjoin('province as g', 'b.province_c', '=', 'g.province_c')
            ->leftjoin('city as h', 'b.city_c', '=', 'h.city_c')
            ->leftjoin('barangay as i', 'b.barangay_c', '=', 'i.barangay_c')
            ->leftjoin('operating_unit as j', 'b.operating_unit_id', '=', 'j.id')
            ->leftjoin('operation_type as k', 'b.operation_type_id', '=', 'k.id')
            ->leftjoin('suspect_classification as l', 'a.suspect_classification_id', '=', 'l.id')
            ->leftjoin('suspect_category as m', 'a.suspect_category_id', '=', 'm.id')
            ->leftjoin('suspect_status as n', 'a.suspect_status_id', '=', 'n.id')
            ->leftjoin('spot_report_case as o', 'a.suspect_number', '=', 'o.suspect_number')
            ->leftjoin('case_list as p', 'o.case_id', '=', 'p.id')

            ->select(
                'a.id',
                'b.preops_number',
                'b.spot_report_number',
                'b.operation_datetime',
                'f.region_m',
                'g.province_m',
                'h.city_m',
                'i.barangay_m',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'd.ndis_id',
                'd.listed',
                'd.remarks',
                'j.name as operating_unit',
                'k.name as operation_type',
                'l.name as suspect_classification',
                'm.name as suspect_category',
                'n.name as status',
                'b.street',
                'p.description as case',
                'o.docket_number',
                'o.case_status',

            )
            ->where('b.operation_lvl', 1)
            ->where(function ($query)  use ($param) {
                return $query->where('b.spot_report_number', 'LIKE', '%' . $param . '%')
                    ->orWhere('b.preops_number', 'LIKE', '%' . $param . '%');
            })
            ->orderby('a.lastname', 'asc')
            ->paginate(20);

        return view('drug_management.drug_management_list_data', compact('data1'))->render();
    }
}
