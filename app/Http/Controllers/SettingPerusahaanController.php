<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingPerusahaan;

class SettingPerusahaanController extends Controller
{
    public function index()
    {
         return response(SettingPerusahaan::select()->first());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return response(SettingPerusahaan::select()->first());
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
              'name'      => 'required',
              'email'     => 'required|string|email',
              'no_telp'   => 'required',
              'alamat'    => 'required',
          ]);

          $setting_perusahaan = SettingPerusahaan::find($id);
          $setting_perusahaan->update([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'email' => $request->email
          ]);

          return response()->json([
                    'message' => 'Success',
                    'data' => $setting_perusahaan
                 ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
