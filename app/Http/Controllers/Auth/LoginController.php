<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;


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

    protected function credentials(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        return ['email' => $email, 'password' => $password, 'is_logged_in' => 0];
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->is_logged_in == 1) {
            $errors = [$this->username() => trans('auth.notactivated')];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    
    
    
    protected function authenticated(Request $request)
    {
        $data = request()->all();
        $all_users = DB::table('users')
            ->where('regional_office_id', Auth::user()->regional_office_id)
            ->where('is_logged_in', 1)
            ->count();

        if ($data['user_log_type'] == 1) {
            if ($all_users == 1) {
                DB::table('users')->where('email', $data['email'])->update(
                    array(
                        'is_logged_in' => 2,
                    )
                );
            } else {
                DB::table('users')->where('email', $data['email'])->update(
                    array(
                        'is_logged_in' => 1,
                    )
                );
            }
        } else {
            DB::table('users')->where('email', $data['email'])->update(
                array(
                    'is_logged_in' => 2,
                )
            );
        }
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
