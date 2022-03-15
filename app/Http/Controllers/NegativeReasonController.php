<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\NegativeReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NegativeReasonController extends Controller
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
        $data = NegativeReason::all();

        return view('negative_reason.negative_reason_list', compact('data'));
    }

    public function add()
    {
        return view('negative_reason.negative_reason_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:negative_reason'
        ]);

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('negative_reason')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Negative Reason Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on negative reason setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new negative reason!');
    }

    public function edit($id)
    {
        $negative_reason = DB::table('negative_reason')->where('id', $id)->get();

        return view('negative_reason.negative_reason_edit', compact('negative_reason'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);

        $pos_data = array(
            'name' =>  $request->name,
            'description' =>  $request->description,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('negative_reason')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Negative Reason Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on negative reason setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated negative reason!');
    }
}
