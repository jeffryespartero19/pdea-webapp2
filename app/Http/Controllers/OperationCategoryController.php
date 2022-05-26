<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\OperationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationCategoryController extends Controller
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
        $data = OperationCategory::all();
        $operation_classification = DB::table('operation_classification')->where('status', true)->orderby('name', 'asc')->get();

        return view('operation_category.operation_category_list', compact('data', 'operation_classification'));
    }

    public function add()
    {
        $operation_classification = DB::table('operation_classification')->where('status', true)->orderby('name', 'asc')->get();

        return view('operation_category.operation_category_add', compact('operation_classification'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:operation_category'
        ]);

        $form_data = array(
            'operation_classification_id' => $request->operation_classification_id,
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('operation_category')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Operation Category Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on operation category setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new operation category!');
    }

    public function edit($id)
    {
        $operation_category = DB::table('operation_category')->where('id', $id)->get();
         $operation_classification = DB::table('operation_classification')->where('status', true)->orderby('name', 'asc')->get();

        return view('operation_category.operation_category_edit', compact('operation_category', 'operation_classification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'operation_classification_id' => $request->operation_classification_id,
            'name' =>  $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('operation_category')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Operation Category Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on operation category setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated operation category!');
    }
}
