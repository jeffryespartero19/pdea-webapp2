<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\DrugType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrugTypeController extends Controller
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
        $data = DrugType::all();

        return view('drug_type.drug_type_list', compact('data'));
    }

    public function add()
    {
        return view('drug_type.drug_type_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:drug_type'
        ]);

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'sub_category' => $request->sub_category,
            'unit_measurement' => $request->unit_measurement,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('drug_type')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Drug Type Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on drug type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new drug type!');
    }

    public function edit($id)
    {
        $drug_type = DB::table('drug_type')->where('id', $id)->get();

        return view('drug_type.drug_type_edit', compact('drug_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'description' =>  $request->description,
            'sub_category' => $request->sub_category,
            'unit_measurement' => $request->unit_measurement,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('drug_type')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Drug Type Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on drug type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated drug type!');
    }
}
