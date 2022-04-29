<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;

class ReportGenerationController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_level_id == 2) {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.created_at')
                ->where('a.report_status', 0)
                ->orderby('spot_report_number', 'asc')
                ->get();

            $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        } else {
            $data = DB::table('spot_report_header as a')
                ->leftjoin('operating_unit as b', 'a.operating_unit_id', '=', 'b.id')
                ->leftjoin('operation_type as c', 'a.operation_type_id', '=', 'c.id')
                ->join('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->select('a.id', 'a.spot_report_number', 'a.operation_datetime', 'b.name as operating_unit', 'c.name as operation_type', 'a.status', 'a.created_at')
                ->where('a.report_status', 0)
                ->where('d.id', Auth::user()->regional_office_id)
                ->orderby('spot_report_number', 'asc')
                ->get();

            $region = DB::table('region as a')
                ->join('regional_office as d', 'a.region_c', '=', 'd.region_c')
                ->where('d.id', Auth::user()->regional_office_id)
                ->get();
        }


        $operating_unit = DB::table('operating_unit')->where('status', true)->orderby('name', 'asc')->get();
        $operation_type = DB::table('operation_type')->where('status', true)->orderby('name', 'asc')->get();

        return view('report_generation.report_generation_list', compact('data', 'region', 'operating_unit', 'operation_type'));
    }
}
