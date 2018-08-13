<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaporanOrder;
use App\DetailPesanan;
use App\Produk;
use Illuminate\Support\Facades\DB;

class LaporanOrderController extends Controller
{
    public function view()
    {
        $dataLaporan = [];
        $laporan_order = DB::table('pesanans')
            ->join('users', 'pesanans.pelanggan_id', '=', 'users.id')
            ->select('users.name as nama_pelanggan', 'pesanans.id as id_pesanan', 'pesanans.created_at as waktu_pesan', 'pesanans.total', 'pesanans.status_pesanan')
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
                'id_laporan' => $laporan->id_pesanan,
                'nama_pelanggan' => $laporan->nama_pelanggan,
                'waktu' => $laporan->waktu_pesan,
                'total' => $laporan->total,
                'detail_order' => $detail_order_array,
                'status_pesanan' => $laporan->status_pesanan
            ];
        }
        return response($dataLaporan);
    }
}
