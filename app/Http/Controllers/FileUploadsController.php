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

    public function preops_files_list()
    {

        if (Auth::user()->user_level_id == 2) {

            $region_c = DB::table('regional_office as a')
                ->leftjoin('users as b', 'a.id', '=', 'b.regional_office_id')
                ->select('a.region_c')
                ->where('b.id', Auth::user()->id)
                ->get();

            $file_uploads = DB::table('issuance_of_preops_files as a')
                ->leftjoin('preops_header as b2', 'a.preops_number', '=', 'b2.preops_number')
                ->select('a.filenames as filename', 'a.preops_number as t_number')
                ->where('b2.region_c', $region_c[0]->region_c)
                ->paginate(20);


            return view('file_uploads.preops_file_uploads_list', compact('file_uploads'));
        } else {
            $file_uploads = DB::table('issuance_of_preops_files as a')
                ->select('a.filenames as filename', 'a.preops_number as t_number')
                ->paginate(20);

            return view('file_uploads.preops_file_uploads_list', compact('file_uploads'));
        }
    }

    public function afteroperation_files_list()
    {

        if (Auth::user()->user_level_id == 2) {

            $region_c = DB::table('regional_office as a')
                ->join('users as b', 'a.id', '=', 'b.regional_office_id')
                ->select('a.region_c')
                ->where('b.id', Auth::user()->id)
                ->get();

            $file_uploads = DB::table('after_operation_files as a')
                ->leftjoin('preops_header as b2', 'a.preops_number', '=', 'b2.preops_number')
                ->select('a.filenames as filename', 'a.preops_number as t_number')
                ->where('b2.region_c', $region_c[0]->region_c)
                ->paginate(20);


            return view('file_uploads.afteroperation_file_uploads_list', compact('file_uploads'));
        } else {
            $file_uploads = DB::table('after_operation_files as a')
                ->select('a.filenames as filename', 'c.preops_number as t_number')
                ->paginate(20);

            return view('file_uploads.afteroperation_file_uploads_list', compact('file_uploads'));
        }
    }

    public function spotreport_files_list()
    {

        if (Auth::user()->user_level_id == 2) {

            $region_c = DB::table('regional_office as a')
                ->leftjoin('users as b', 'a.id', '=', 'b.regional_office_id')
                ->select('a.region_c')
                ->where('b.id', Auth::user()->id)
                ->get();

            $file_uploads = DB::table('spot_report_files as b')
                ->leftjoin('spot_report_header as c', 'b.spot_report_number', '=', 'c.spot_report_number')
                ->select('b.filenames as filename', 'b.spot_report_number as t_number')
                ->where('c.region_c', $region_c[0]->region_c)
                ->paginate(20);


            return view('file_uploads.spotreport_file_uploads_list', compact('file_uploads'));
        } else {
            $file_uploads = DB::table('spot_report_files as a')
                ->select('a.filenames as filename', 'a.spot_report_number as t_number')
                ->paginate(20);

            return view('file_uploads.spotreport_file_uploads_list', compact('file_uploads'));
        }
    }

    public function progressreport_files_list()
    {

        if (Auth::user()->user_level_id == 1) {

            $region_c = DB::table('regional_office as a')
                ->leftjoin('users as b', 'a.id', '=', 'b.regional_office_id')
                ->select('a.region_c')
                ->where('b.id', Auth::user()->id)
                ->get();

            $file_uploads = DB::table('progress_report_files as a')
                ->leftjoin('spot_report_header as c', 'a.spot_report_number', '=', 'c.spot_report_number')
                ->select('a.filenames as filename', 'a.spot_report_number as t_number')
                ->where('c.region_c', $region_c[0]->region_c)
                ->paginate(20);

            return view('file_uploads.progressreport_file_uploads_list', compact('file_uploads'));
        } else {
            $file_uploads = DB::table('progress_report_files as a')
                ->select('a.filenames as filename', 'a.spot_report_number as t_number')
                ->paginate(20);

            return view('file_uploads.progressreport_file_uploads_list', compact('file_uploads'));
        }
    }

    public function search_files(Request $request)
    {

        $q = $request->q;

        if (Auth::user()->user_level_id == 2) {

            $region_c = DB::table('regional_office as a')
                ->leftjoin('users as b', 'a.id', '=', 'b.regional_office_id')
                ->select('a.region_c')
                ->where('b.id', Auth::user()->id)
                ->get();

            if ($q != "") {

                if ($request->type == 1) {
                    $file_uploads = DB::table('file_upload_list as a')
                        ->leftjoin('issuance_of_preops_files as b', 'a.preops_file_id', '=', 'b.id')
                        ->select('a.filename', 'a.transaction_type', 'b.preops_number as t_number')
                        ->where('a.filename', 'LIKE', '%' . $q . '%')
                        ->orWhere('b.preops_number', 'LIKE', '%' . $q . '%')
                        ->orderby('a.id', 'desc')
                        ->paginate(20)
                        ->setPath('');

                    // dd($file_uploads);

                    $pagination = $file_uploads->appends(array(
                        'q' => $request->q
                    ));

                    if (count($file_uploads) > 0) {
                        return view('file_uploads.preops_file_upload_list', compact('file_uploads'));
                    }
                } else if ($request->type == 2) {
                    $file_uploads = DB::table('file_upload_list as a')
                        ->leftjoin('after_operation_files as c', 'a.after_operation_file_id', '=', 'c.id')
                        ->select('a.filename', 'a.transaction_type', 'c.preops_number as t_number')
                        ->where('a.filename', 'LIKE', '%' . $q . '%')
                        ->orWhere('c.preops_number', 'LIKE', '%' . $q . '%')
                        ->orderby('a.id', 'desc')
                        ->paginate(20)
                        ->setPath('');

                    // dd($file_uploads);

                    $pagination = $file_uploads->appends(array(
                        'q' => $request->q
                    ));

                    if (count($file_uploads) > 0) {
                        return view('file_uploads.afteroperation_file_uploads_list', compact('file_uploads'));
                    }
                } else if ($request->type == 3) {
                    $file_uploads = DB::table('file_upload_list as a')
                        ->leftjoin('spot_report_files as d', 'a.spot_report_file_id', '=', 'd.id')
                        ->select('a.filename', 'a.transaction_type', 'd.spot_report_number as t_number')
                        ->where('a.filename', 'LIKE', '%' . $q . '%')
                        ->orWhere('d.spot_report_number', 'LIKE', '%' . $q . '%')
                        ->orderby('a.id', 'desc')
                        ->paginate(20)
                        ->setPath('');

                    // dd($file_uploads);

                    $pagination = $file_uploads->appends(array(
                        'q' => $request->q
                    ));

                    if (count($file_uploads) > 0) {
                        return view('file_uploads.spotreport_file_uploads_list', compact('file_uploads'));
                    }
                } else if ($request->type == 4) {
                    $file_uploads = DB::table('file_upload_list as a')
                        ->leftjoin('progress_report_files as e', 'a.progress_report_file_id', '=', 'e.id')
                        ->select('a.filename', 'a.transaction_type', 'e.spot_report_number as t_number')
                        ->where('a.filename', 'LIKE', '%' . $q . '%')
                        ->orWhere('e.spot_report_number', 'LIKE', '%' . $q . '%')
                        ->orderby('a.id', 'desc')
                        ->paginate(20)
                        ->setPath('');

                    // dd($file_uploads);

                    $pagination = $file_uploads->appends(array(
                        'q' => $request->q
                    ));

                    if (count($file_uploads) > 0) {
                        return view('file_uploads.progressreport_file_uploads_list', compact('file_uploads'));
                    }
                }
            }
        } else {
            if ($q != "") {

                $file_uploads = DB::table('file_upload_list as a')
                    ->leftjoin('issuance_of_preops_files as b', 'a.preops_file_id', '=', 'b.id')
                    ->leftjoin('after_operation_files as c', 'a.after_operation_file_id', '=', 'c.id')
                    ->leftjoin('spot_report_files as d', 'a.spot_report_file_id', '=', 'd.id')
                    ->leftjoin('progress_report_files as e', 'a.progress_report_file_id', '=', 'e.id')
                    ->select('a.filename', 'a.transaction_type', 'b.preops_number as i_preops_number', 'c.preops_number as a_preops_number', 'd.spot_report_number as s_spot_report_number', 'e.spot_report_number as p_spot_report_number')
                    ->where('a.filename', 'LIKE', '%' . $q . '%')
                    ->orWhere('b.preops_number', 'LIKE', '%' . $q . '%')
                    ->orWhere('c.preops_number', 'LIKE', '%' . $q . '%')
                    ->orWhere('d.spot_report_number', 'LIKE', '%' . $q . '%')
                    ->orWhere('e.spot_report_number', 'LIKE', '%' . $q . '%')
                    ->orderby('a.id', 'desc')
                    ->paginate(20)
                    ->setPath('');

                // dd($file_uploads);

                $pagination = $file_uploads->appends(array(
                    'q' => $request->q
                ));

                if (count($file_uploads) > 0) {
                    return view('file_uploads.file_uploads_list', compact('file_uploads'));
                }
            }
        }

        return view('file_uploads.file_uploads_list')->withMessage('No Details found. Try to search again !');
    }
}
