<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
use App\KeranjangBelanja;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
             $session = Session::get('session_id');
             $keranjang_belanja = KeranjangBelanja::where('session_id',$session)->update(['id_pelanggan' => Auth::User()->id,'session_id' => null]);
             return User::with('role')->where('id',Auth::User()->id)->first();
        }else{
            return Auth::User();
        }
    }
}
