<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NationalityController extends Controller
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
        $data = Nationality::all();

        return view('nationality.nationality_list', compact('data'));
    }

    public function add()
    {
        return view('nationality.nationality_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:nationality'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('nationality')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Nationality Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on nationality setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new nationality!');
    }

    public function edit($id)
    {
        $nationality = DB::table('nationality')->where('id', $id)->get();

        return view('nationality.nationality_edit', compact('nationality'));
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

        DB::table('nationality')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Nationality Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on nationality setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated nationality!');
    }
}
