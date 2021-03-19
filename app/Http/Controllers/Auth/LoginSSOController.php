<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;
use App\User;

class LoginSSOController extends Controller
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

    // use AuthenticatesUsers;
    use RegistersUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function redirectTo()
    {
        switch (Auth::user()->is_admin) {
            case 1:
                $this->redirectTo = '/admin';
                return $this->redirectTo;
                break;
            case 0:
                $this->redirectTo = '/home';
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function loginSSO()
    {
        $router = "https://service.eng.rmuti.ac.th/eng-login/login/?id=10&secret=SAWASDEE&msg=";
        return redirect($router);
    }

    public function getLogin(Request $req)
    {

        //$router = env("SSO_ROUTE", "");

        $server = "http://service.eng.rmuti.ac.th/eng-login/xmlrpc/";

        $app_id = 10;

        $secret = "SAWASDEE";

        $request = xmlrpc_encode_request("getDecrypt", array($app_id, $secret, $req->attribs));
        $context = stream_context_create(array('http' => array(
            'method' => "POST",
            'header' => "Content-Type: text/xml",
            'content' => $request
        )));
        $file = file_get_contents($server, false, $context);
        $response = xmlrpc_decode($file);
        // return $response;
        // $msg = explode(",",$response);
        $attribs = preg_replace(array("/\[/", "/\]/"), '', $response);

        $attribs = preg_replace("/\'/", '"', $attribs);

        $attribs = json_decode($attribs, true);


        $user = User::where('email', $attribs['mail'])->first();
        if($user == null){
            $user = new User;
            $user->email = $attribs['mail'];
            $user->password = Hash::make($attribs['personalId']);
            $user->name = $attribs['firstNameThai'].' '. $attribs['lastNameThai'];
            $user->is_sso = 1;
            $user->type = $attribs['title'];
            $user->save();
        }

        Auth::attempt(['email' => $attribs['mail'], 'password' => $attribs['personalId']]);

        switch (Auth::user()->is_admin) {
            case 1:
                //$this->redirectTo = '/admin';
                return redirect(route('admin'));
                break;
            case 0:
                //$this->redirectTo = '/home';
                return redirect(route('user'));
                break;
            default:
                //$this->redirectTo = '/login';
                return redirect(route('login'));
        }

    }



}

