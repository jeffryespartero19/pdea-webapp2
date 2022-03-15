<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\OperationClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationClassificationController extends Controller
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
        $data = OperationClassification::all();

        return view('operation_classification.operation_classification_list', compact('data'));
    }

    public function add()
    {

        return view('operation_classification.operation_classification_add');
    }

    public function store(Request $request)
    {

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('operation_classification')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Operation Classification Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on operation classification setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new operation classification!');
    }

    public function edit($id)
    {
        $operation_classification = DB::table('operation_classification')->where('id', $id)->get();

        return view('operation_classification.operation_classification_edit', compact('operation_classification'));
    }

    public function update(Request $request, $id)
    {

        $pos_data = array(
            'name' =>  $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('operation_classification')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Operation Classification Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on operation classification setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated operation classification!');
    }
}
