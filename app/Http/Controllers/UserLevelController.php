<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserLevelController extends Controller
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
        $data = UserLevel::all();

        return view('user_levels.user_level_list', compact('data'));
    }

    public function add()
    {
        return view('user_levels.user_level_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:tbluserlevel'
        ]);

        $form_data = array(
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->has('status') ? true : false,
        );

        DB::table('tbluserlevel')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Euser Level Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on user level setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new user level!');
    }

    public function edit($id)
    {
        $user_level = DB::table('tbluserlevel')->where('id', $id)->get();

        return view('user_levels.user_level_edit', compact('user_level'));
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

        DB::table('tbluserlevel')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'User Level Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on user level setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated user level!');
    }
}
