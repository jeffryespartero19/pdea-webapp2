<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\HIO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HIOController extends Controller
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
        $data = HIO::all();

        return view('hio_type.hio_type_list', compact('data'));
    }

    public function add()
    {
        return view('hio_type.hio_type_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:hio_type'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('hio_type')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'HIO Type Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on HIO type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new HIO type!');
    }

    public function edit($id)
    {
        $hio_type = DB::table('hio_type')->where('id', $id)->get();

        return view('hio_type.hio_type_edit', compact('hio_type'));
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

        DB::table('hio_type')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'HIO Type Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on HIO type setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated HIO type!');
    }
}
