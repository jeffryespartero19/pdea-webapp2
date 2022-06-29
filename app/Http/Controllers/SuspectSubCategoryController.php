<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\SuspectSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspectSubCategoryController extends Controller
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
        $data = SuspectSubCategory::all();

        return view('suspect_sub_category.suspect_sub_category_list', compact('data'));
    }

    public function add()
    {
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('name', 'asc')->get();
        return view('suspect_sub_category.suspect_sub_category_add', compact('suspect_category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:suspect_sub_category'
        ]);

        $form_data = array(
            'name' => $request->name,
            'suspect_category_id' => $request->suspect_category_id,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('suspect_sub_category')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Sub-Category Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on suspect sub-category setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new suspect sub-category!');
    }

    public function edit($id)
    {
        $suspect_sub_category = DB::table('suspect_sub_category')->where('id', $id)->get();
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('name', 'asc')->get();

        return view('suspect_sub_category.suspect_sub_category_edit', compact('suspect_sub_category', 'suspect_category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'suspect_category_id' => $request->suspect_category_id,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('suspect_sub_category')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Sub-Category Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on suspect sub-category setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated suspect sub-category!');
    }
}
