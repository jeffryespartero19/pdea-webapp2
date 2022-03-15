<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Identifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentifierController extends Controller
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
        $data = Identifier::all();

        return view('identifier.identifier_list', compact('data'));
    }

    public function add()
    {
        return view('identifier.identifier_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:identifier'
        ]);

        $form_data = array(
            'name' => $request->name,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('identifier')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Identifier Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on identifier setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new identifier!');
    }

    public function edit($id)
    {
        $identifier = DB::table('identifier')->where('id', $id)->get();

        return view('identifier.identifier_edit', compact('identifier'));
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

        DB::table('identifier')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Identifier Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on identifier setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated identifier!');
    }
}
