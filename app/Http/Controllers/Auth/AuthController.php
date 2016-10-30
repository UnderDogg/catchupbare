<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\InvalidConfirmationCodeException;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\AuditRepository as Audit;
use Modules\Core\Models\Staff;
use Auth;
use Flash;


use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
/*use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;*/

//use Illuminate\Support\Facades\Auth;


use Redirect;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new staff, as well as the
    | authentication of existing staff. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |RegistersUsers, ThrottlesLogins
    */
    use AuthenticatesUsers;



    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/staffpanel';

    // if auth is user
    protected $redirectToUser = '/profile';
    /* Direct After Logout */
    protected $redirectAfterLogout = '/';
    protected $loginPath = '/login';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->auth = $auth;
      $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'username' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:staff',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $page_title = "Login";
        //return view('staff.auth.login');
        return view('auth.login', compact('page_title'));
    }





    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|min:3|max:255',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');


        if (Auth::attempt($credentials)) {

            $staff = Auth::user();
            // Allow only if staff is root or enabled.

            if ( $staff->enabled )
            {
                Flash::success("Welcome " . Auth::user()->first_name);
                return redirect()->intended('/adminpanel');

            }
            else
            {
                Auth::logout();
                return redirect(route('login'))
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([
                        'username' => trans('admin/staff/general.error.login-failed-staff-disabled'),
                    ]);
            }
        }

        return redirect('/auth/login')
            ->withInput($request->only('username', 'remember'))
            ->withErrors([
                'username' => $this->getFailedLoginMessage(),
            ]);
    }



    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout()
    {
        Auth::logout();
        //$this->auth->logout();
        return redirect()->intended('/');
    }



    /**
     * Failed Login Message
     *
     *
     */
    protected function getFailedLoginMessage()
    {
        return 'Username or Password are just wrong';
    }





    protected function authenticated($request,$user){
        if($user->role === 'admin'){
            return redirect()->intended('adminpanel'); //redirect to admin panel
        }

        return redirect()->intended('/'); //redirect to standard staff homepage
    }





    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('staff');
    }
}