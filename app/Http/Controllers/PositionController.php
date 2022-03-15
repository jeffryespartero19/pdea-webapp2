<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
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
        $data = Position::all();

        return view('position.position_list', compact('data'));
    }

    public function add()
    {
        return view('position.position_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:position'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('position')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Position Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on position setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new position!');
    }

    public function edit($id)
    {
        $position = DB::table('position')->where('id', $id)->get();

        return view('position.position_edit', compact('position'));
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

        DB::table('position')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Position Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on position setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated position!');
    }
}
