<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\SuspectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspectCategoryController extends Controller
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
        $data = SuspectCategory::all();

        return view('suspect_category.suspect_category_list', compact('data'));
    }

    public function add()
    {
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();
        return view('suspect_category.suspect_category_add', compact('suspect_classification'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:suspect_category'
        ]);

        $form_data = array(
            'name' => $request->name,
            'suspect_classification_id' => $request->suspect_classification_id,
            'status' => $request->has('status') ? true : false,
            'hvt' => $request->has('hvt') ? true : false,
        );

        DB::table('suspect_category')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Category Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on suspect category setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new suspect category!');
    }

    public function edit($id)
    {
        $suspect_category = DB::table('suspect_category')->where('id', $id)->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();

        return view('suspect_category.suspect_category_edit', compact('suspect_category', 'suspect_classification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'suspect_classification_id' => $request->suspect_classification_id,
            'status' => $request->has('status') ? true : false,
            'hvt' => $request->has('hvt') ? true : false,
        );

        DB::table('suspect_category')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Category Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on suspect category setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated suspect category!');
    }
}
