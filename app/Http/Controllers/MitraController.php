<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mitra;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return response(Mitra::select()->get());
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
              'nama_mitra'      => 'required',
              'no_telp'     => 'required',
              'alamat'     => 'required',
          ]);

          $mitra = Mitra::create(['nama_mitra' => $request->nama_mitra, 'no_telp' => $request->no_telp, 'alamat' => $request->alamat ]);

          return $mitra;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return Mitra::find($id); 
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
              'nama_mitra'      => 'required',
              'no_telp'     => 'required',
              'alamat'     => 'required',
          ]);

          return $mitra = Mitra::find($id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mitra::destroy($id);
        return response(200);
    }
}
