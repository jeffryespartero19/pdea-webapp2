<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request)
    {
        $data = request()->all();
        $this_user = DB::table('users')->where('email', $data['email'])->get();
        $all_users = DB::table('users')->get();

        foreach ($all_users as $au) {
            DB::table('users')->where('is_logged_in', '<', 1)->update(
                array(
                    'is_logged_in' => 0,
                )
            );
        }

        DB::table('users')->where('email', $data['email'])->update(
            array(
                'is_logged_in' => $data['user_log_type'],
            )
        );
    }

    public function logout(Request $request)
    {
        $id = Auth::user()->id;

        DB::table('users')->where('id', $id)->update(
            array(
                'is_logged_in' => 0,
            )
        );

        Auth::logout();
        return redirect('/');
    }
}
