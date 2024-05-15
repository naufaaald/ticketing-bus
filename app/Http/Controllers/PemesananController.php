<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rute;
use App\Models\Category;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class PemesananController extends Controller
{
    //construktor cek status pembayaran yang masih belum bayar dan sudah melewati batas waktu
    public function __construct()
    {
        $status = ['Belum Bayar'];
        $pemesanan = Pemesanan::whereIn('status', $status)->get();
        foreach ($pemesanan as $val) {
            $pembayaran = Pembayaran::where('kode_pemesanan', $val->kode)->first();
            if ($pembayaran) {
                $batas_waktu = $pembayaran->batas_waktu_pembayaran;
                if (now() > $batas_waktu) {
                    $pembayaran->status = 'Gagal';
                    $pembayaran->save();
                    $val->status = 'Gagal';
                    $val->save();
                }
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruteAwal = Rute::orderBy('start')->get()->groupBy('start');
        if (count($ruteAwal) > 0) {
            foreach ($ruteAwal as $key => $value) {
                $data['start'][] = $key;
            }
        } else {
            $data['start'] = [];
        }
        $ruteAkhir = Rute::orderBy('end')->get()->groupBy('end');
        if (count($ruteAkhir) > 0) {
            foreach ($ruteAkhir as $key => $value) {
                $data['end'][] = $key;
            }
        } else {
            $data['end'] = [];
        }
        $category = Category::orderBy('name')->get();
        return view('client.index', compact('data', 'category'));
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
        if ($request->category) {
            $category = Category::find($request->category);
            $data = [
                'start' => $request->start,
                'end' => $request->end,
                'category' => $category->id,
                'waktu' => $request->waktu,
            ];
            $data = Crypt::encrypt($data);
            return redirect()->route('show', ['id' => $category->slug, 'data' => $data]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $data)
    {
        $user = auth()->user(); // Mendapatkan data pengguna yang sudah login
        $data = Crypt::decrypt($data);
        $status = ['Berhasil', 'Belum Bayar', 'Verifikasi'];
        $category = Category::find($data['category']);
        $rute = Rute::with('transportasi')->where('start', $data['start'])->where('end', $data['end'])->get();
        if ($rute->count() > 0) {
            foreach ($rute as $val) {
                $pemesanan = Pemesanan::where('rute_id', $val->id)->where('waktu')->count();
                $dataPesanan = Pemesanan::where('rute_id', $val->id)
                    ->whereDate('waktu', $data['waktu'])
                    ->whereIn('status', $status)
                    ->pluck('kursi');
                if ($val->transportasi) {
                    $kursi = Transportasi::find($val->transportasi_id)->jumlah - $pemesanan;
                    if ($val->transportasi->category_id == $category->id) {
                        $dataRute[] = [
                            'harga' => $val->harga,
                            'start' => $val->start,
                            'end' => $val->end,
                            'tujuan' => $val->tujuan,
                            'transportasi' => $val->transportasi->name,
                            'kode' => $val->transportasi->kode,
                            'kursi' => $kursi,
                            'waktu' => $data['waktu'],
                            'id' => $val->id,
                            'dataPesanan' => $dataPesanan,
                        ];
                    }
                }
            }
            sort($dataRute);
        } else {
            $dataRute = [];
        }
        $id = $category->name;

        return view('client.show', compact('id', 'dataRute', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = Crypt::decrypt($id);
        // $rute = Rute::find($data['id']);
        // $transportasi = Transportasi::find($rute->transportasi_id);
        // return view('client.kursi', compact('data', 'transportasi'));
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
    public function destroy()
    {
        //
    }

    public function pesan(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'idTiket' => 'required',
                'namaPenumpang' => 'required',
                'nomorTelepon' => 'required',
                'email' => 'required|email',
                'alamat' => 'required',
                'nomorKursi' => 'required',
                'harga' => 'required',
                'waktu' => 'required',
            ]);
            $user =  Auth::user()->id;
            $huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $kodePemesanan = strtoupper(substr(str_shuffle($huruf), 0, 7));
            $rute = Rute::with('transportasi.category')->find($request->idTiket);
            $waktu = $request->waktu . " " . $rute->jam;
            $harga = (int)str_replace(['Rp.', '.', ','], '', $request->harga);
            //status yang diizinkan
            $status = ['Berhasil', 'Belum Bayar', 'Verifikasi'];
            // buat object store data pemesanan dengan lockForUpdate
            $pemesanan = Pemesanan::where('rute_id', $request->idTiket)
                ->whereDate('waktu', $request->waktu)
                ->whereIn('status', $status)
                ->lockForUpdate()
                ->get();
            // cek apakah kursi yang dipilih sudah ada yang memesan
            $kursiOrder = explode(',', $request->nomorKursi);
            $kursiNonAvailable = $pemesanan->pluck('kursi')->toArray();
            // cek kursi konflik
            $kursiKonflik  = array_intersect($kursiOrder, $kursiNonAvailable);
            // cek jika terjadi konflik kursi
            if (!empty($kursiKonflik)) {
                // return response()->json(['error' => 'Kursi yang anda pilih sudah dipesan oleh orang lain']);
                return redirect()->back()->with('error-sweet-alert', 'Kursi yang anda pilih sudah dipesan oleh penumpang lain, Silahkan pilih kursi yang lain');
            } else {
                $store = new Pemesanan();
                $store->kode = $kodePemesanan;
                $store->nama_penumpang = $request->namaPenumpang;
                $store->no_telepon = $request->nomorTelepon;
                $store->email = $request->email;
                $store->alamat = $request->alamat;
                $store->kursi = $request->nomorKursi;
                $store->waktu = $waktu;
                $store->status = 'Belum Bayar';
                $store->total = $harga;
                $store->pemesan_id = $user;
                $store->rute_id = $request->idTiket;

                $pembayaran = new Pembayaran();
                $pembayaran->kode_pemesanan = $kodePemesanan;
                $pembayaran->batas_waktu_pembayaran = Carbon::now()->addMinutes(2)->format('Y-m-d H:i:s');
                $store->save();
                $pembayaran->save();

                //ambil id pesanan
                $kodePemesanan = Crypt::encrypt($kodePemesanan);
            }
            DB::commit();
            return redirect()->route('payment', ['kode' => $kodePemesanan])->with('success', 'Pemesanan berhasil, silahkan lakukan pembayaran sebelum batas waktu pembayaran');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/')->with('error', $e->getMessage());
        }
    }
}
