<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Auth;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    public function view() {
         return response(User::select()->leftJoin('role_user','users.id','role_user.user_id')->where('role_id',1)->get());
    }

    public function detailAkun() {
        return response(User::where('id',Auth::User()->id)->first());
    }

    public function simpanDetailAkun(Request $request) {

      $this->validate($request, [
          'name'      => 'required|string|max:255',
          'email'     => 'required|string|email|max:255|unique:users,email,'. $request->id,
      ]);

      if ($request->password != "") {
        $this->validate($request, [
            'password'  => 'required|min:6|confirmed'
        ]);

        $user = User::where('id', $request->id)->update([
            'password'  => bcrypt($request->password)
        ]);
      }

        $user = User::where('id', $request->id)->update([
            'name'    => $request->name,
            'email'   => $request->email,
        ]);

    }

    public function simpanAlamat(Request $request) {

      $this->validate($request, [
          'name'        => 'required|string|max:255',
          'no_telp'     => 'required|numeric',
          'alamat'      => 'required',
          'provinsi'    => 'required',
          'kabupaten'   => 'required',
          'kecamatan'   => 'required',
          'kelurahan'   => 'required'
      ]);

      $user = User::where('id', $request->id)->update([
        'name'=> $request->name,
        'no_telp'=> $request->no_telp,
        'alamat'=> $request->alamat,
        'provinsi'=> $request->provinsi,
        'kabupaten'=> $request->kabupaten,
        'kecamatan'=> $request->kecamatan,
        'kelurahan'=> $request->kelurahan,
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $memberRole = Role::where('name', 'admin')->first();
        $user->attachRole($memberRole);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(User::whereId($id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        User::whereId($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        return response(200);
    }
}
