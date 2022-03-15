<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\EducationalAttainment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EducationalAttainmentController extends Controller
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
        $data = EducationalAttainment::all();

        return view('educational_attainment.educational_attainment_list', compact('data'));
    }

    public function add()
    {
        return view('educational_attainment.educational_attainment_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:educational_attainment'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('educational_attainment')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Educational Attainment Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on educational attainment setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new educational attainment!');
    }

    public function edit($id)
    {
        $educational_attainment = DB::table('educational_attainment')->where('id', $id)->get();

        return view('educational_attainment.educational_attainment_edit', compact('educational_attainment'));
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

        DB::table('educational_attainment')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Educational Attainment Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on educational attainment setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated educational attainment!');
    }
}
