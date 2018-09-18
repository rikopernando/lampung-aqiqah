<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pesanan;
use App\DetailPesanan;
use App\KirimTempatLain;
use App\Bank;
use DB;
use Mail;

class CekTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk mengecek transfer yang masuk ke rekening, dan langsung kirim email apabila ada pesanan sudah dibayar. Data yang dicocokan adalah total pesanan';
    private $pesanans = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
       // $this->pesanans = Pesanan::whereNull('status_pesanan')->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->pesanans->each(function ($pesanans) {

           $curl = curl_init();
           curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/aolk41VdzJx/mutation/search/'.$pesanans->total);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
           curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Authorization: Bearer RyiDKMig6CYQoxrsJW1UsV9u2mjzvRpnqI0auirBVprjXTLGPM'
           ]);
           $mutation = json_decode(curl_exec($curl),true);

           if(count($mutation['mutation']) > 0){

                $pesanan = DB::table('pesanans')
                    ->join('users', 'pesanans.pelanggan_id', '=', 'users.id')
                    ->select('users.name as nama_pelanggan', 'pesanans.updated_at as tanggal_dikonfirmasi', 'pesanans.metode_pembayaran', 'users.email', 'pesanans.id', 'pesanans.total', 'pesanans.kode_unik', 'users.alamat', 'users.no_telp')
                    ->where('pesanans.id', $pesanans->id)
                    ->first();

                $detail_pesanan = DetailPesanan::with('produk')->where('id_pesanan',$pesanans->id)->get();
                $kirim_tempat_lain = KirimTempatLain::where('id_pesanan',$pesanans->id);
                $bank = Bank::where('default',1)->first();

                Mail::send('mails.pesanan_dikonfirmasi', compact('pesanan','detail_pesanan','kirim_tempat_lain','bank'), function ($message) use ($pesanan) {
                      $message->from('verifikasi@andaglos.id','Aqiqah Lampung');
                      $message->to($pesanan->email);
                      $message->subject('Pesanan Anda Telah Kami Konfirmasi');
                });

                Pesanan::whereId($pesanans->id)->update(['status_pesanan' => 1]);
           }
        });
    }
}
