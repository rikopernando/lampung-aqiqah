<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaporanOrder;
use App\DetailPesanan;
use App\Produk;
use Illuminate\Support\Facades\DB;

class LaporanOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataLaporan = [];
        $laporan_order = DB::table('laporan_orders')
                            ->join('users', 'laporan_orders.id_pelanggan', '=', 'users.id')
                            ->join('pesanans', 'laporan_orders.id_pesanan', '=', 'pesanans.id')
                            ->select('users.name as nama_pelanggan', 'laporan_orders.id_pesanan', 'pesanans.created_at as waktu_pesan', 'laporan_orders.id as id_laporan', 'pesanans.total')
                            ->get();

        foreach ($laporan_order as $laporan) {
            $detail_order_array = [];

            $detail_order = DetailPesanan::select('id_produk', 'jumlah_produk')->where('id_pesanan', $laporan->id_pesanan)->get();
            
            foreach ($detail_order as $order) {
                $produk = Produk::select('nama_produk', 'harga_jual')->whereId($order->id_produk)->first();
                $detail_order_array[] = [
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga_jual,
                    'qty' => $order->jumlah_produk
                ];
            }

            $dataLaporan[] = [
                'id_laporan' => $laporan->id_laporan,
                'nama_pelanggan' => $laporan->nama_pelanggan,
                'waktu' => $laporan->waktu_pesan,
                'total' => $laporan->total,
                'detail_order' => $detail_order_array
            ];
        }
        return response($dataLaporan);
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
        //
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
