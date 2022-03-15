<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackagingController extends Controller
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
        $data = Packaging::all();

        return view('packaging.packaging_list', compact('data'));
    }

    public function add()
    {
        return view('packaging.packaging_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:packaging'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('packaging')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Packaging Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on packaging setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new packaging!');
    }

    public function edit($id)
    {
        $packaging = DB::table('packaging')->where('id', $id)->get();

        return view('packaging.packaging_edit', compact('packaging'));
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

        DB::table('packaging')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Packaging Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on packaging setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated packaging!');
    }
}
