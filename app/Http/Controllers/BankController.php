<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;

class BankController extends Controller
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
       $bank = Bank::paginate(10);

       return response()->json([
            'bank' => $bank
       ],200);
    }

    public function search(Request $request){
        $bank = Bank::where(function ($bank) use ($request){
            $bank->orWhere('nama_bank','LIKE','%'. $request->search .'%')
                 ->orWhere('atas_nama','LIKE','%'. $request->search .'%')
                 ->orWhere('no_rek','LIKE','%'. $request->search .'%');
        })->paginate(10);

       return response()->json([
            'bank' => $bank
       ],200);
    }

    public function countDefault(){
         $countDefaultBank = Bank::select()->where('default',1)->count();
         return response($countDefaultBank);
    }


    public function updateDefaultBank($id, $boolean) {
      $update_bank = Bank::find($id);
      $update_bank->update([
        'default'  => 1,
      ]);

      $updateNonDefault = Bank::where('id','!=',$id);
      $updateNonDefault->update([
        'default'  => 0,
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
        $this->validate($request, [
            'nama_bank' => 'required',
            'atas_nama' => 'required',
            'no_rek' => 'required|unique:banks,no_rek|numeric',
        ]);

        $master_bank = Bank::create([
            'nama_bank' => $request->nama_bank,
            'atas_nama' => $request->atas_nama,
            'no_rek' => $request->no_rek,
            'default' => 0
        ]);
        
        return response($master_bank);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        return response(Bank::whereId($id)->first());
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
        
       $this->validate($request, [
            'nama_bank' => 'required',
            'atas_nama' => 'required',
            'no_rek' => 'required|unique:banks,no_rek,'.$id.'|numeric',
        ]);

       $update_bank = Bank::whereId($id);
       $update_bank->update([
        'nama_bank'=>$request->nama_bank,
        'atas_nama'=>$request->atas_nama,
        'no_rek'=>$request->no_rek
        ]);
        
     return response(1);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::destroy($id);
        return response(200);
    }
}
