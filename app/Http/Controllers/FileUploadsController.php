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
        $file_uploads = DB::table('file_upload_list as a')
        ->leftjoin('issuance_of_preops_files as b', 'a.preops_file_id', '=', 'b.id')
        ->leftjoin('after_operation_files as c', 'a.after_operation_file_id', '=', 'c.id')
        ->leftjoin('spot_report_files as d', 'a.spot_report_file_id', '=', 'd.id')
        ->leftjoin('progress_report_files as e', 'a.progress_report_file_id', '=', 'e.id')
        ->select('a.filename', 'a.transaction_type', 'b.preops_number as i_preops_number', 'c.preops_number as a_preops_number', 'd.spot_report_number as s_spot_report_number', 'e.spot_report_number as p_spot_report_number')
        ->get();

        return view('file_uploads.file_uploads_list', compact('file_uploads'));
    }

    public function add()
    {
        return view('file_uploads.file_uploads_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:file_uploads'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('file_uploads')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Ethnic Group Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on ethnic group setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new ethnic group!');
    }

    public function edit($id)
    {
        $file_uploads = DB::table('file_uploads')->where('id', $id)->get();

        return view('file_uploads.file_uploads_edit', compact('file_uploads'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('file_uploads')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Ethnic Group Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on ethnic group setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated ethnic group!');
    }
}
