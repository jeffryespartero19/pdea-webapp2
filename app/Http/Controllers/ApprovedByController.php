<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\ApprovedBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovedByController extends Controller
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
        $data = DB::table('approved_by as a')
            ->leftjoin('regional_office as b', 'a.ro_code', '=', 'b.ro_code')
            ->leftjoin('officer_position as c', 'a.officer_position_id', '=', 'c.id')
            ->select('a.id','a.name', 'b.name as regional_office', 'c.name as officer_position', 'a.status')
            ->orderby('a.name', 'asc')->get();

        return view('approved_by.approved_by_list', compact('data'));
    }

    public function add()
    {
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $officer_position = DB::table('officer_position')->orderby('name', 'asc')->get();

        return view('approved_by.approved_by_add', compact('regional_office', 'officer_position'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:approved_by',
            'ro_code' => 'required',
            'officer_position_id' => 'required',
        ]);

        $form_data = array(
            'name' => $request->name,
            'ro_code' => $request->ro_code,
            'officer_position_id' => $request->officer_position_id,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('approved_by')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Approved By Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on approved by setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new approved by!');
    }

    public function edit($id)
    {
        $approved_by = DB::table('approved_by')->where('id', $id)->get();
        $regional_office = DB::table('regional_office')->orderby('print_order', 'asc')->get();
        $officer_position = DB::table('officer_position')->orderby('name', 'asc')->get();

        return view('approved_by.approved_by_edit', compact('approved_by', 'regional_office', 'officer_position'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'ro_code' => 'required',
            'officer_position_id' => 'required',
        ]);

        $pos_data = array(
            'name' => $request->name,
            'ro_code' => $request->ro_code,
            'officer_position_id' => $request->officer_position_id,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('approved_by')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Approved By Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on approved by setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated approved by!');
    }
}
