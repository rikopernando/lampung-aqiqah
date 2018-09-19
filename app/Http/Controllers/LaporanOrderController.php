<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaporanOrder;
use App\DetailPesanan;
use App\Produk;
use App\Pesanan;
use App\KirimTempatLain;
use App\Bank;
use Illuminate\Support\Facades\DB;
use Mail;

class LaporanOrderController extends Controller
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

    public function view()
    {
        $dataLaporan = [];
        $laporan_order = Pesanan::LaporanOrder()->orderBy('pesanans.created_at', 'desc')->paginate(10);

        foreach ($laporan_order as $laporan) {
            $dataLaporan[] = [
                'id_pesanan' => $laporan->id_pesanan,
                'nama_pelanggan' => $laporan->nama_pelanggan,
                'waktu' => $laporan->waktu_pesan,
                'total' => $laporan->total,
                'status_pesanan' => $laporan->status_pesanan,
                'timeago' => $this->timeago(time() - strtotime($laporan->waktu_pesan))
            ];
        }

        return response()->json([
            'laporan_order' => $this->pagination($dataLaporan,$laporan_order,'laporan-order/view')
        ]);
    }
    
    public function search(Request $request)
    {
        $dataLaporan = [];
        $laporan_order = Pesanan::LaporanOrder()->where(function ($laporan_order) use ($request){
                   $laporan_order->orWhere('users.name','LIKE','%'. $request->search .'%') 
                   ->orWhere('pesanans.id','LIKE','%'. $request->search .'%')
                   ->orWhere('pesanans.created_at','LIKE','%'. $request->search .'%')
                   ->orWhere('pesanans.total','LIKE','%'. $request->search .'%')
                   ->orWhere('pesanans.status_pesanan','LIKE','%'. $request->search .'%');
            })
            ->orderBy('pesanans.created_at', 'desc')
            ->paginate(10);

        foreach ($laporan_order as $laporan) {
            $dataLaporan[] = [
                'id_pesanan' => $laporan->id_pesanan,
                'nama_pelanggan' => $laporan->nama_pelanggan,
                'waktu' => $laporan->waktu_pesan,
                'total' => $laporan->total,
                'status_pesanan' => $laporan->status_pesanan,
                'timeago' => $this->timeago(time() - strtotime($laporan->waktu_pesan))
            ];
        }

        return response()->json([
            'laporan_order' => $this->pagination($dataLaporan,$laporan_order,'laporan-order/pencarian')
        ]);
    }
    
    public function pagination($dataLaporan,$laporan_order,$url){

        $respons['current_page']   = $laporan_order->currentPage();
        $respons['data']           = $dataLaporan;
        $respons['first_page_url'] = $laporan_order->firstItem();
        $respons['from']           = 1;
        $respons['last_page']      = $laporan_order->lastPage();
        $respons['last_page_url']  = $laporan_order->lastPage();
        $respons['next_page_url']  = $laporan_order->nextPageUrl();
        $respons['path']           = url($url);
        $respons['per_page']       = $laporan_order->perPage();
        $respons['prev_page_url']  = $laporan_order->previousPageUrl();
        $respons['to']             = $laporan_order->perPage();
        $respons['total']          = $laporan_order->total();

        return $respons;

    }

    public function detail_order($id_pesanan) {
        // dibedakan jadi tiga table (di vue)
        // -    info pemesan
        // -    detail peserta
        // -    alamat pengiriman

        $pesanan = DB::table('pesanans')
            ->join('users', 'pesanans.pelanggan_id', '=', 'users.id')
            ->leftJoin('kirim_tempat_lains', 'pesanans.id', '=', 'kirim_tempat_lains.id_pesanan')
            ->select(
                // Info Pemesan = ip
                'users.name as ip_nama_pemesan', 
                'users.email as ip_email',
                'users.no_telp as ip_no_telp',
                'users.alamat as ip_alamat',
                'users.provinsi as ip_provinsi',
                'users.kabupaten as ip_kabupaten',
                'users.kecamatan as ip_kecamatan',
                'users.kelurahan as ip_kelurahan',

                // Detail Peserta = dp
                'pesanans.nama_peserta as dp_nama_peserta', 
                'pesanans.tempat_tanggal_lahir as dp_ttl', 
                'pesanans.tempat_lahir as dp_tempat_lahir', 
                'pesanans.jenis_kelamin as dp_jenis_kelamin', 
                'pesanans.nama_ayah as dp_nama_ayah', 
                'pesanans.nama_ibu as dp_nama_ibu', 

                // Alamat Pengiriman = ap
                'kirim_tempat_lains.nama_depan as ap_nama_depan',
                'kirim_tempat_lains.nama_belakang as ap_nama_belakang',
                'kirim_tempat_lains.company_name as ap_company_name',
                'kirim_tempat_lains.alamat as ap_alamat',
                'kirim_tempat_lains.provinsi as ap_provinsi',
                'kirim_tempat_lains.kabupaten as ap_kabupaten',
                'kirim_tempat_lains.kecamatan as ap_kecamatan',
                'kirim_tempat_lains.kelurahan as ap_kelurahan',
                'kirim_tempat_lains.no_telp as ap_no_telp'
            )
            ->where('pesanans.id', '=', $id_pesanan)
            ->first();

        $result = [];

        // info pemesan
        $entri[] = [
            'Nama Pemesan' => $pesanan->ip_nama_pemesan,
            'Email' => $pesanan->ip_email,
            'Nomor Telepon' => $pesanan->ip_no_telp,
            'Alamat' => $pesanan->ip_alamat,
            'Provinsi' => $this->getNamaDaerah($pesanan->ip_provinsi, 1),
            'Kabupaten' => $this->getNamaDaerah($pesanan->ip_kabupaten, 2),
            'Kecamatan' => $this->getNamaDaerah($pesanan->ip_kecamatan, 3),
            'Kelurahan' => $this->getNamaDaerah($pesanan->ip_kelurahan, 4)
        ];

        // detail peserta
        $entri[] = [
            'Nama Peserta' => $pesanan->dp_nama_peserta,
            'TTL' => $pesanan->dp_ttl,
            'Tempat Lahir' => $pesanan->dp_tempat_lahir,
            'Jenis Kelamin' => ($pesanan->dp_jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan'),
            'Nama Ayah' => $pesanan->dp_nama_ayah,
            'Nama Ibu' => $pesanan->dp_nama_ibu
        ];

        // alamat pengiriman
        $entri[] = [
            'Nama Depan' => $pesanan->ap_nama_depan,
            'Nama Belakang' => $pesanan->ap_nama_belakang,
            'Perusahaan' => $pesanan->ap_company_name,
            'Alamat' => $pesanan->ap_alamat,
            'Nomor Telepon' => $pesanan->ap_no_telp,
            'Provinsi' => $this->getNamaDaerah($pesanan->ap_provinsi, 1),
            'Kabupaten' => $this->getNamaDaerah($pesanan->ap_kabupaten, 2),
            'Kecamatan' => $this->getNamaDaerah($pesanan->ap_kecamatan, 3),
            'Kelurahan' => $this->getNamaDaerah($pesanan->ap_kelurahan, 4)
        ];

        $result = [];
        foreach ($entri as $entriData) {
            $array = [];

            foreach ($entriData as $entriKey => $entriVal) {
                $array[] = [
                    'entri' => $entriKey,
                    'keterangan' => $entriVal
                ];
            }

            $result[] = $array;
        }

        if ($array[0]['keterangan'] == null) {

            $result[2] = [
                ['entri' => 'Nama', 'keterangan' => $pesanan->ip_nama_pemesan],
                ['entri' => 'Alamat', 'keterangan' => $pesanan->ip_alamat],
                ['entri' => 'Nomor Telepon', 'keterangan' => $pesanan->ip_no_telp],
                ['entri' => 'Provinsi', 'keterangan' => $this->getNamaDaerah($pesanan->ip_provinsi, 1)],
                ['entri' => 'Kabupaten', 'keterangan' => $this->getNamaDaerah($pesanan->ip_kabupaten, 2)],
                ['entri' => 'Kecamatan', 'keterangan' => $this->getNamaDaerah($pesanan->ip_kecamatan, 3)],
                ['entri' => 'Kelurahan', 'keterangan' => $this->getNamaDaerah($pesanan->ip_kelurahan, 4)]
            ];
        }

        return response()->json($result);
    }

    public function infoPesanan($id_pesanan) {
        $detailPesanan = DB::table('detail_pesanans')
            ->join('pesanans', 'detail_pesanans.id_pesanan', '=', 'pesanans.id')
            ->select('id_produk', 'jumlah_produk', 'pesanans.kode_unik', 'pesanans.total')
            ->where('detail_pesanans.id_pesanan', '=', $id_pesanan)
            ->get();

        // return response()->json($detailPesanan);
        $infoPesanan = [];
        foreach ($detailPesanan as $detail) {
            $produk = Produk::select('nama_produk', 'harga_jual')->whereId($detail->id_produk)->first();
            $infoPesanan[0][] = [
                'nama_produk' => $produk->nama_produk,
                'qty' => $detail->jumlah_produk,
                'harga' => $produk->harga_jual,
                'subtotal' => ($produk->harga_jual * $detail->jumlah_produk)
            ];
    
            $infoPesanan[1] = [
                ['entri' => 'Kode Unik', 'keterangan' => $detail->kode_unik],
                ['entri' => 'Subtotal', 'keterangan' => $detail->total]
            ];
        }


        return response()->json($infoPesanan);
    }

    public function statusPesanan($id_pesanan) {
        $pesanan = Pesanan::select('status_pesanan')->whereId($id_pesanan)->first();

        return response()->json(['status_pesanan' => $pesanan->status_pesanan]);
    }

    public function timeago($waktu) {

        if ($waktu < 59) {
            $str = $waktu . ' detik yang lalu';
        }
        else if ($waktu > 59 && $waktu < 3600) {
            if (($waktu % 60) == 0) {
                $str = (ceil($waktu / 60) - 1) . ' menit yang lalu';
            } else {
                $str = (ceil($waktu / 60) - 1) . ' menit ' . ceil(($waktu % 60) - 1) . ' detik yang lalu';
            }
        }

        // 86400 detik adalah 1 hari
        // Jika lebih dari 1 jam dan kurang dari 1 hari
        else if ($waktu > 3599 && $waktu < 86400) {
            $str = (ceil(($waktu / 3600)) - 1) . ' jam yang lalu';
        }

        // 604800 detik adalah 1 minggu
        // Jika lebih dari 1 hari dan kurang dari 1 minggu
        else if ($waktu > 86400 && $waktu < 604800) {
            $str = (ceil(($waktu / 86400)) - 1) . ' hari yang lalu';
        }

        // 2592000 detik adalah 1 bulan
        // Jika lebih dari 1 minggu dan kurang dari 1 bulan
        else if ($waktu > 604800 && $waktu < 2592000) {
            if (($waktu % 604800) < 86400) {
                $str = (ceil(($waktu / 604800)) - 1) . ' minggu yang lalu';
            }

            // Jika sisa bagi lebih dari 1 hari
            else {
                $str = (ceil(($waktu / 604800)) - 1) . ' minggu ' . ceil(($waktu % 604800) / 86400 - 1) . ' hari yang lalu';
            }
        }

        // Jika lebih dari 1 bulan
        else if ($waktu > 2592000) {

            // Jika sisa bagi kurang dari 1 minggu
            if (($waktu % 2592000) < 604800) {
                // Maka hanya tampilkan jumlah bulannya
                $str = (ceil(($waktu / 2592000)) - 1) . ' bulan yang lalu';
            } else {
                // Jika sisa bagi (bulan dilanjutkan dengan minggu) kurang dari 1 hari
                if (($waktu % 2592000 % 604800) < 86400) {
                    // Maka hanya tampilkan jumlah bulan dan kelebihan minggunya
                    $str = (ceil(($waktu / 2592000)) - 1) . ' bulan ' . (ceil(($waktu % 2592000) / 604800) - 1) . ' minggu yang lalu';
                }
                // Jika sisa bagi (bulan dilanjutkan dengan minggu) lebih dari 1 hari
                else {
                    // Maka tampilkan jumlah bulan, kelebihan minggu dan harinya
                    $str = (ceil(($waktu / 2592000)) - 1) . ' bulan ' . (ceil(($waktu % 2592000) / 604800) - 1) . ' minggu ' . (ceil(($waktu % 2592000 % 604800) / 86400) - 1) . ' hari yang lalu';
                }
            }
        }
        if (!empty($str)) {
            return $str;
        } else {
            return null;
        }
    }

    public function ubahStatusPesanan(Request $request) {
        return Pesanan::whereId($request->id_pesanan)->update([
            'status_pesanan' => $request->angka
        ]);
    }

    public function getNamaDaerah($id, $n) {
        // n:
        // 1 = Provinsi
        // 2 = Kabupaten
        // 3 = Kecamatan
        // 4 = Kelurahan

        if ($id == null) {
            return null;
        } else {
            switch ($n) {
                case 1:
                    return DB::table('provinces')->whereId($id)->first()->name;
                break;
                case 2:
                    return DB::table('cities')->whereId($id)->first()->name;
                break;
                case 3:
                    return DB::table('districts')->whereId($id)->first()->name;
                break;
                case 4:
                    return DB::table('villages')->whereId($id)->first()->name;
            }
        }
    }

    public function kirimEmail(Request $request) {
        $pesanan = DB::table('pesanans')
            ->join('users', 'pesanans.pelanggan_id', '=', 'users.id')
            ->select('users.name as nama_pelanggan', 'pesanans.updated_at as tanggal_dikonfirmasi', 'pesanans.metode_pembayaran', 'users.email', 'pesanans.id', 'pesanans.total', 'pesanans.kode_unik', 'users.alamat', 'users.no_telp')
            ->where('pesanans.id', $request->id_pesanan)
            ->first();
        $detail_pesanan = DetailPesanan::with('produk')->where('id_pesanan',$pesanan->id)->get();
        $kirim_tempat_lain = KirimTempatLain::where('id_pesanan',$pesanan->id);
        $bank = Bank::where('default',1)->first();

        $arrayN = [
            1 => ['pesanan_dikonfirmasi', 'Konfirmasi'],
            2 => ['pesanan_dikirimkan', 'Kirim'],
            3 => ['pesanan_diselesaikan', 'Selesaikan']
        ];

        Mail::send('mails.'. $arrayN[$request->n][0], compact('pesanan','detail_pesanan','kirim_tempat_lain','bank'), function ($message) use ($pesanan, $request, $arrayN) {
              $message->from('verifikasi@andaglos.id','Aqiqah Lampung');
              $message->to($pesanan->email);
              $message->subject('Pesanan Anda Telah Kami '. $arrayN[$request->n][1]);
        });

    }
}
