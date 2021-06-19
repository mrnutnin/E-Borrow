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

class LogoutSSOController extends Controller
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
    // use RegistersUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function logoutSSO()
    {

        $router = "https://service.eng.rmuti.ac.th/eng-login/logout/?id=10&secret=SAWASDEE&fbclid=IwAR30BH5y3HBdNbo3VKq4ECU8RJp38Zmx7DpT9fUpdEWRauSzsCPbrmsmCHo";
        // dd($router);
        return redirect($router);
    }

    public function getLogout(Request $req)
    {

        // $router = "https://service.eng.rmuti.ac.th/eng-login/logout/?id=10&secret=SAWASDEE&fbclid=IwAR30BH5y3HBdNbo3VKq4ECU8RJp38Zmx7DpT9fUpdEWRauSzsCPbrmsmCHo";
        return redirect(route('logout'));


    }




}
