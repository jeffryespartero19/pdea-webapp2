<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersController extends Controller
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
        $users = DB::table('users')
            ->orderby('name', 'asc')
            ->get();
        $user_level = DB::table('tbluserlevel')->where('status', true)->orderby('name', 'asc')->get();
        $position = DB::table('position')->where('status', true)->orderby('name', 'asc')->get();
        $regional_office = DB::table('regional_office')->where('status', true)->orderby('print_order', 'asc')->get();

        return view('users.list', compact('users', 'user_level', 'position', 'regional_office'));
    }

    public function store(Request $request)
    {

        

        $regional_office = DB::table('regional_office')->where('id', $request->regional_office_id)->get();

        if ($request->user_id > 0) {
            if ($request->password == '' || $request->password == null) {

                $form_data = array(
                    'name' => $request->name,
                    'email' => $request->email,
                    'email_verified_at' => Carbon::now(),
                    'position_id' => $request->position_id,
                    'user_level_id' => $request->user_level_id,
                    'regional_office_id' => $request->regional_office_id,
                    'active' => $request->has('active') ? true : false,
                    'region_c' => $regional_office[0]->region_c,
                );
                
            } else {
                $form_data = array(
                    'name' => $request->name,
                    'email' => $request->email,
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make($request->password),
                    'position_id' => $request->position_id,
                    'user_level_id' => $request->user_level_id,
                    'regional_office_id' => $request->regional_office_id,
                    'active' => $request->has('active') ? true : false,
                    'region_c' => $regional_office[0]->region_c,
                );
            }
            DB::table('users')->where('id', $request->user_id)->update($form_data);
        } else {
            $request->validate([
                'name' => 'required|string|min:3|unique:users',
                'email' => 'required|string|min:3|unique:users'
            ]);
            
            $form_data = array(
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make($request->password),
                'position_id' => $request->position_id,
                'user_level_id' => $request->user_level_id,
                'regional_office_id' => $request->regional_office_id,
                'active' => $request->has('active') ? true : false,
                'region_c' => $regional_office[0]->region_c,
            );

            DB::table('users')->insert($form_data);
        }


        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Users List',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on users list.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new user!');
    }
}
