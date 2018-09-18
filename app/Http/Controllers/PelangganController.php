<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Pesanan;
use Auth;
use Excel;

class PelangganController extends Controller
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
         $pelanggans = User::select()->leftJoin('role_user','users.id','role_user.user_id')->where('role_id',2)->paginate(10);
         return response()->json([
             'pelanggan' => $pelanggans 
         ],200);
    }

    public function search(Request $request){

         $pelanggans = User::select()->leftJoin('role_user','users.id','role_user.user_id')->where('role_id',2)
                ->where(function ($pelanggans) use ($request){
                $pelanggans->orWhere('name','LIKE','%'. $request->search .'%')
                       ->orWhere('email','LIKE','%'. $request->search .'%')
                       ->orWhere('alamat','LIKE','%'. $request->search .'%')
                       ->orWhere('no_telp','LIKE','%'. $request->search .'%');
               })->paginate(10);

         return response()->json([
             'pelanggan' => $pelanggans 
         ],200);
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
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_telp' => 'required',
            'alamat' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat
        ]);
        $memberRole = Role::where('name', 'member')->first();
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
        return response(User::where('id',$id)->first());
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
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        $pelanggans = User::whereId($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::where('pelanggan_id',$id)->count();
        if($pesanan === 0){
            $user = User::destroy($id);
            return response(200);
        }else{
            return response()->json([
                'message' => 'Pelanggan Tidak Bisa Dihapus, karena sudah terpakai' 
            ]);
        }
    }

    public function downloadExcel(){
        Excel::create('Pelanggan', function ($excel){
            $excel->sheet('Pelanggan', function($sheet){
              $row = 1;
              $sheet->row($row,[
                'PELANGGAN' 
              ]);

              $row = 3;
              $sheet->row($row,[
                'Nama',
                'Email',
                'No. Telpon',
                'Alamat'
              ]);

              $row = ++$row;

              $pelanggan = User::select()->leftJoin('role_user','users.id','role_user.user_id')->where('role_id',2)->get();
              foreach($pelanggan as $pelanggans){
                $sheet->row(++$row,[
                    $pelanggans->name,
                    $pelanggans->email,
                    $pelanggans->no_telp,
                    $pelanggans->alamat
                ]);
              }
            });        
        })->export('xls');
    }
}
