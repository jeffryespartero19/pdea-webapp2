<?php

namespace App\Http\Controllers;

use App\User;
use App\Audit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessRightsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $user = User::findOrFail($id);
        $info = DB::table('users')->where('id', $id)->get();

        $menus_hrm = DB::table('menus')
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select(DB::raw('menu_id'))
                    ->from('access')
                    ->where('user_id', $user->id);
            })
            ->select('menus.status', 'menus.id', 'menus.menu', 'menus.description')
            ->where(['module_id' => 1]);
        $menus_hrt = DB::table('menus')
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select(DB::raw('menu_id'))
                    ->from('access')
                    ->where('user_id', $user->id);
            })
            ->select('menus.status', 'menus.id', 'menus.menu', 'menus.description')
            ->where(['module_id' => 2]);

        $menus_hrp = DB::table('menus')
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select(DB::raw('menu_id'))
                    ->from('access')
                    ->where('user_id', $user->id);
            })
            ->select('menus.status', 'menus.id', 'menus.menu', 'menus.description')
            ->where(['module_id' => 3]);

        $menus_cpm = DB::table('menus')
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select(DB::raw('menu_id'))
                    ->from('access')
                    ->where('user_id', $user->id);
            })
            ->select('menus.status', 'menus.id', 'menus.menu', 'menus.description')
            ->where(['module_id' => 4]);

        $hrm_menu = DB::table('access')
            ->join('menus', 'access.menu_id', '=', 'menus.id')
            ->select('access.status', 'access.menu_id as id', 'menus.menu', 'menus.description')
            ->where(['access.user_id' => $id, 'menus.module_id' => 1])
            ->union($menus_hrm)
            ->orderBy('menu', 'asc')
            ->get();

        $hrt_menu = DB::table('access')
            ->join('menus', 'access.menu_id', '=', 'menus.id')
            ->select('access.status', 'access.menu_id as id', 'menus.menu', 'menus.description')
            ->where(['access.user_id' => $id, 'menus.module_id' => 2])
            ->union($menus_hrt)
            ->orderBy('menu', 'asc')
            ->get();

        $hrp_menu = DB::table('access')
            ->join('menus', 'access.menu_id', '=', 'menus.id')
            ->select('access.status', 'access.menu_id as id', 'menus.menu', 'menus.description')
            ->where(['access.user_id' => $id, 'menus.module_id' => 3])
            ->union($menus_hrp)
            ->orderBy('menu', 'asc')
            ->get();

        $cpm_menu = DB::table('access')
            ->join('menus', 'access.menu_id', '=', 'menus.id')
            ->select('access.status', 'access.menu_id as id', 'menus.menu', 'menus.description')
            ->where(['access.user_id' => $id, 'menus.module_id' => 4])
            ->union($menus_cpm)
            ->orderBy('menu', 'asc')
            ->get();

        return view('users.access_rigths', compact('info', 'hrm_menu', 'hrt_menu', 'hrp_menu', 'cpm_menu'));
    }

    public function update_access(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = array(
            'employee_no' => $request->employee_no,
            'is_admin' => $request->has('is_admin') ? true : false,
            'locked' => $request->has('locked') ? true : false,
            'locked_date' => $request->has('locked') ? date("Y-m-d", strtotime(now())) : null,
            'with_coc_access' => $request->has('with_coc_access') ? true : false,
            'with_sap_access' => $request->has('with_sap_access') ? true : false,
            'with_settings_access' => $request->has('with_settings_access') ? true : false,
            'with_geomapping_access' => $request->has('with_geomapping_access') ? true : false,
            'with_file_upload_access' => $request->has('with_file_upload_access') ? true : false,
            'with_drug_management_access' => $request->has('with_drug_management_access') ? true : false,
            'with_drug_verification_access' => $request->has('with_drug_verification_access') ? true : false,
        );

        DB::table('users')->where(['id' => $id])->update($data);

        $data_menu_table = request()->all();

        if (isset($data_menu_table['status'])) {
            $arr_len = count($data_menu_table['menu_id']);
            $arr_status_len = count($data_menu_table['status']) - 1;

            $status_index = 0;

            $menu_access = [];

            for ($i = 0; $i < $arr_len; $i++) {
                if ($data_menu_table['menu_id'][$i] != NULL) {
                    if ($data_menu_table['status'][$status_index] == $data_menu_table['menu_id'][$i]) {
                        if ($status_index < $arr_status_len) {
                            $status_index += 1;
                        }
                        $status = true;
                    } else {
                        $status = false;
                    }

                    $menu_access = [
                        'user_id'   =>  $id,
                        'status'    =>  $status,
                        'menu_id'   =>  $data_menu_table['menu_id'][$i],
                    ];
                }

                DB::table('access')->updateOrInsert(['menu_id' => $data_menu_table['menu_id'][$i], 'user_id' => $id], $menu_access);
            }
        } else {
            $arr_len = count($data_menu_table['menu_id']);

            $status_index = 0;

            $menu_access = [];

            for ($i = 0; $i < $arr_len; $i++) {
                if ($data_menu_table['menu_id'][$i] != NULL) {

                    $status = false;

                    $menu_access = [
                        'user_id'   =>  $id,
                        'status'    =>  $status,
                        'menu_id'   =>  $data_menu_table['menu_id'][$i],
                    ];
                }

                DB::table('access')->updateOrInsert(['menu_id' => $data_menu_table['menu_id'][$i], 'user_id' => $id], $menu_access);
            }
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Access Rights',
            'activity' => 'Update',
            'description' => 'Update ' . $user->name . ' access rights informations.',
        );

        Audit::create($data_audit);

        return redirect()->route('access_rigths', [$id])->with('success', 'You have successfully updated access rights!');
    }
}
