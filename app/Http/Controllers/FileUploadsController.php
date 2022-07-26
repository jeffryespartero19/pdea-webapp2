<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileUploadsController extends Controller
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

        if (Auth::user()->user_level_id == 2) {

            $file_uploads = DB::table('file_upload_list as a')
                ->leftjoin('issuance_of_preops_files as b', 'a.preops_file_id', '=', 'b.id')
                ->leftjoin('after_operation_files as c', 'a.after_operation_file_id', '=', 'c.id')
                ->leftjoin('spot_report_files as d', 'a.spot_report_file_id', '=', 'd.id')
                ->leftjoin('progress_report_files as e', 'a.progress_report_file_id', '=', 'e.id')
                ->leftjoin('preops_header as b2', 'b.preops_number', '=', 'b2.preops_number')
                ->leftjoin('preops_header as c2', 'c.preops_number', '=', 'c2.preops_number')
                ->leftjoin('spot_report_header as f', 'd.spot_report_number', '=', 'f.spot_report_number')
                ->leftjoin('spot_report_header as g', 'e.spot_report_number', '=', 'g.spot_report_number')
                ->leftjoin('regional_office as h', 'b2.region_c', '=', 'h.region_c')
                ->leftjoin('regional_office as h1', 'c2.region_c', '=', 'h1.region_c')
                ->leftjoin('regional_office as h2', 'f.region_c', '=', 'h2.region_c')
                ->leftjoin('regional_office as h3', 'g.region_c', '=', 'h3.region_c')
                ->where(function ($query) {
                    $query->where('h.id', Auth::user()->regional_office_id)
                        ->orWhere('h1.id', Auth::user()->regional_office_id)
                        ->orWhere('h2.id', Auth::user()->regional_office_id)
                        ->orWhere('h3.id', Auth::user()->regional_office_id);
                })
                ->select('a.filename', 'a.transaction_type', 'b.preops_number as i_preops_number', 'c.preops_number as a_preops_number', 'd.spot_report_number as s_spot_report_number', 'e.spot_report_number as p_spot_report_number')
                ->get();

            return view('file_uploads.file_uploads_list', compact('file_uploads'));
        } else {
            $file_uploads = DB::table('file_upload_list as a')
                ->leftjoin('issuance_of_preops_files as b', 'a.preops_file_id', '=', 'b.id')
                ->leftjoin('after_operation_files as c', 'a.after_operation_file_id', '=', 'c.id')
                ->leftjoin('spot_report_files as d', 'a.spot_report_file_id', '=', 'd.id')
                ->leftjoin('progress_report_files as e', 'a.progress_report_file_id', '=', 'e.id')
                ->select('a.filename', 'a.transaction_type', 'b.preops_number as i_preops_number', 'c.preops_number as a_preops_number', 'd.spot_report_number as s_spot_report_number', 'e.spot_report_number as p_spot_report_number')
                ->get();

            return view('file_uploads.file_uploads_list', compact('file_uploads'));
        }
    }
}
