<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class PembayaranController extends Controller
{
    public function index($kode)
    {
        $kode = Crypt::decrypt($kode);
        $pemesan = Pemesanan::where('kode', $kode)->first();
        $pembayaran = Pembayaran::where('kode_pemesanan', $kode)->first();

        return view('client.pembayaran', compact('pemesan', 'pembayaran'));
    }
    public function updateStatus(Request $request)
    {
        $kode_pemesanan = $request->input('kode_pemesanan');
        $pemesanan = Pemesanan::where('kode', $kode_pemesanan)->first();
        $pembayaran = Pembayaran::where('kode_pemesanan', $kode_pemesanan)->first();
        // dd($kode_pemesanan);
        if ($pembayaran) {
            $batas_waktu = $pembayaran->batas_waktu;
            $status = $pembayaran->status;

            if ($status == 'Belum Bayar' && now() > $batas_waktu) {
                $pembayaran->status = 'Gagal';
                $pembayaran->save();
                $pemesanan->status = 'Gagal';
                $pemesanan->save();
                return response()->json(['status' => 'success']);
            }
        }
    }
}
