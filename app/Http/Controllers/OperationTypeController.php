<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\OperationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationTypeController extends Controller
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
        $data = OperationType::all();
        $operation_category = DB::table('operation_category')->where('status', true)->orderby('name', 'asc')->get();

        return view('operation_type.operation_type_list', compact('data', 'operation_category'));
    }

    public function add()
    {
        $operation_category = DB::table('operation_category')->where('status', true)->orderby('name', 'asc')->get();

        return view('operation_type.operation_type_add', compact('operation_category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:operation_type'
        ]);

        $form_data = array(
            'operation_classification_id' => 0,
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
            'is_warrant' => $request->has('is_warrant') ? true : false,
            'is_testbuy' => $request->has('is_testbuy') ? true : false,
            'show_preops' => $request->has('show_preops') ? true : false,
            'show_spot_report' => $request->has('show_spot_report') ? true : false,
            'operation_category_id' => $request->operation_category_id,
        );

        DB::table('operation_type')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'OperationType Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on operation type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new operation type!');
    }

    public function edit($id)
    {
        $operation_type = DB::table('operation_type')->where('id', $id)->get();
        // $operation_classification = DB::table('operation_classification')->where('status', true)->orderby('name', 'asc')->get();
        $operation_category  = DB::table('operation_category')->where('status', true)->orderby('name', 'asc')->get();

        return view('operation_type.operation_type_edit', compact('operation_type', 'operation_category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'operation_classification_id' => 0,
            'name' =>  $request->name,
            'status' => $request->has('status') ? true : false,
            'is_warrant' => $request->has('is_warrant') ? true : false,
            'is_testbuy' => $request->has('is_testbuy') ? true : false,
            'show_preops' => $request->has('show_preops') ? true : false,
            'show_spot_report' => $request->has('show_spot_report') ? true : false,
            'operation_category_id' => $request->operation_category_id,
        );

        DB::table('operation_type')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'OperationType Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on operation type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated operation type!');
    }
}
