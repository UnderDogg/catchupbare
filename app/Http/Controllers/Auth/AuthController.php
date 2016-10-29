<?php namespace App\Http\Controllers\Auth;

use App\Exceptions\InvalidConfirmationCodeException;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\AuditRepository as Audit;
use Modules\Core\Models\Staff;
use Auth;
use Flash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
/*use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;*/
use Illuminate\Http\Request;
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
    public function __construct(){$this->middleware('guest', ['except' => 'getLogout']);}

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
     * Create a new staff instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $staff = Staff::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return $staff;
    }


    protected function authenticated($request,$user){
        if($user->role === 'admin'){
            return redirect()->intended('admin'); //redirect to admin panel
        }

        return redirect()->intended('/'); //redirect to standard staff homepage
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
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $page_title = "Login";

        return view('auth.login', compact('page_title'));
    }

    protected function getFailedLoginMessage()
    {
        return 'Usuário e senha inválidos.';
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $page_title = "Register";

        return view('auth.register', compact('page_title'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $staffname = "N/A";
        if ($request->has('username')) {
            $staffname = $request['username'];
        }
        Audit::log(null, trans('general.audit-log.category-register'), trans('general.audit-log.msg-registration-attempt', ['username' => $staffname]));

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $staff = $this->create($request->all());
        Audit::log(null, trans('general.audit-log.category-register'), trans('general.audit-log.msg-account-created', ['username' => $staff->username]));

        if ((new Setting())->get('auth.enable_user_on_create')) {
            $staff->enabled = true;
            $staff->save();
            Audit::log(null, trans('general.audit-log.category-register'), trans('general.audit-log.msg-account-enabled', ['username' => $staff->username]));
        }

        $staff->emailValidation();

        if ($staff->enabled) {
            Flash::success("Welcome " . $staff->first_name . ", your account has been created");
            Auth::login($staff);
            $request->flashExcept(['password', 'password_confirmation']);
            return redirect($this->redirectPath());
        } else {
            if ((new Setting())->get('auth.email_validation')) {
                Flash::success("Welcome " . $staff->first_name . ", your account has been created, an email has been sent to your address to complete the registration process.");
                $request->flashExcept(['password', 'password_confirmation']);
                return redirect(route('confirm_emailPost'));
            } else {
                Flash::success("Welcome " . $staff->first_name . ", your account has been created, and will soon be enabled.");
                $request->flashExcept(['password', 'password_confirmation']);
                return redirect(route('home'));
            }
        }

    }

    public function verify($confirmation_code, Request $request)
    {
        if( ! $confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $staff = Staff::whereConfirmationCode($confirmation_code)->first();

        if ( ! $staff)
        {
            throw new InvalidConfirmationCodeException;
        }

        $staff->confirmed = 1;
        $staff->confirmation_code = null;
        Audit::log(null, trans('general.audit-log.category-register'), trans('general.audit-log.msg-email-validated', ['username' => $staff->username]));

        if ((new Setting())->get('auth.enable_user_on_validation')) {
            $staff->enabled = true;
            Audit::log(null, trans('general.audit-log.category-register'), trans('general.audit-log.msg-account-enabled', ['username' => $staff->username]));
        }

        $staff->save();

        Flash::message(trans('general.status.email-validated'));

        $request->session()->reflash();
        return Redirect::route('home');
    }

    public function getVerify()
    {
        $page_title = "Verify email";

        return view('auth.verify', compact('page_title'));
    }

    public function postVerify(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|size:30',
        ]);

        $token = $request['token'];

        return $this->verify($token, $request);
    }

}