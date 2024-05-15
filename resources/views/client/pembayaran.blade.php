@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
    <div class="row">
        <div class="col-12 " style="margin-top: -15px">
            <a href="{{ url('/') }}" class="text-dark btn"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
            <div class="row mt-2">
                <div class="col-12 mb-4">
                    <div class="card o-hidden border-0 shadow h-100 py-2">
                        <div class="card-body">
                            <div class="d-lg-flex no-gutters align-items-center justify-content-between">
                                <div class="font-weight-bold text-gray-800 text-uppercase mb-2">
                                    Pembayaran
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card o-hidden border-0 shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="bg-warning rounded">
                                    <h6 class="font-weight-bold text-gray-900 text-uppercase p-2 align-items-center m-0 ">
                                        Lakukan Pembayar Dalam Waktu
                                        <span id="countdown"></span>
                                    </h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-7 col-12 order-last order-lg-first">
            <div class="row">
                <div class="col mb-4">
                    <div class="card o-hidden border-0 shadow  py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                        Kirim Ke Nomor Rekening Berikut
                                    </div>
                                    <div class="d-lg-flex justify-content-between">
                                        <div>
                                            <small class="text-muted text-uppercase">Bank BRI</small>
                                            <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                0166-01-020870-53-8
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-dark">
                                                <b>PT Jambi Transport</b>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-lg-flex justify-content-between">
                                        <div>
                                            <small class="text-muted text-uppercase">Bank BCA</small>
                                            <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                8050-654598
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-dark">
                                                <b>PT Jambi Transport</b>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-lg-flex justify-content-between mb-3">
                                        <div>
                                            <small class="text-muted text-uppercase">Bank Mandiri</small>
                                            <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                111-33-0927425-9
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-dark">
                                                <b>PT Jambi Transport</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card o-hidden border-0 shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                        Upload Bukti Pembayaran
                                    </div>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama-pengirim">Nama Pengirim</label>
                                            <input type="text" class="form-control" id="nama-pengirim"
                                                placeholder="Nama Pengirim">
                                        </div>
                                        <div class="form-group">
                                            <label for="tujuan-bank-pembayaran">Tujuan Bank Pembayaran</label>
                                            <select class="form-control" name="tujuan-bank-pembayaran"
                                                id="tujuan-bank-pembayaran">
                                                <option value="BRI">Bank BRI</option>
                                                <option value="BNI">Bank BNI</option>
                                                <option value="BCA">Bank BCA</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="bukti-pembayaran">Bukti Pembayaran</label>
                                            <input type="file" class="form-control-file" id="bukti-pembayaran"
                                                name="bukti-pembayaran">
                                        </div>
                                        <div class="d-block">
                                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-12 order-first ">
            <div class="row">
                <div class="col mb-4">
                    <div class="card o-hidden border-0 shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                    Detail Pesanan
                                </div>
                            </div>
                            <ul class="list-group mb-3  rounded-0">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0">1 x Ticket Jambi - Bukittinggi</h6>
                                        <small class="text-dark">Senin 12 Maret 2024 - No Kursi : 3B</small>
                                    </div>
                                    <span class="text-muted">Rp 175.000</span>
                                </li>
                                <li class="list-group-item text-dark d-flex justify-content-between">
                                    <span>Total (RP)</span>
                                    <strong>Rp 175.000</strong>
                                </li>
                            </ul>
                            <form class="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Promo code">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success">Redeem</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <div class="card o-hidden border-0 shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                        Data Penumpang
                                    </div>
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-5 ">
                                            Nama
                                        </div>
                                        <div class="col-7 text-dark">
                                            Muhammad Naufal Defriandi
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-5 ">
                                            Nomor Telepon
                                        </div>
                                        <div class="col-7 text-dark">
                                            081254546565
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mb-2 ">
                                        <div class="col-5">
                                            Alamat
                                        </div>
                                        <div class="col-7 text-dark">
                                            Jl. Jendral Sudirman No. 123 Bukittinggi
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-5">
                                            Email
                                        </div>
                                        <div class="col-7 text-dark">
                                            naufal@gmail.com
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Mengatur waktu akhir perhitungan mundur
        let batasPembayaran = '{{ $pembayaran->batas_waktu_pembayaran }}';
        let kodePemesanan = '{{ $pembayaran->kode_pemesanan }}';
        var countDownDate = new Date(batasPembayaran).getTime();

        // Memperbarui hitungan mundur setiap 1 detik
        var x = setInterval(function() {

            // Untuk mendapatkan tanggal dan waktu hari ini
            var now = new Date().getTime();

            // Temukan jarak antara sekarang dan tanggal hitung mundur
            var distance = countDownDate - now;

            // Perhitungan waktu untuk hari, jam, menit dan detik
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            if (seconds < 10) {
                seconds = "0" + seconds;
            }

            // Keluarkan hasil dalam elemen dengan id = "demo"
            document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds;

            // Jika hitungan mundur selesai, tulis beberapa teks 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
                // jika expired lakukan perubahan status pembayaran dan kemudian redirect ke halaman pemesanan

                $.ajax({
                    type: "GET",
                    url: "{{ route('payment.update') }}",
                    data: {
                        kode_pemesanan: kodePemesanan,
                    },
                    success: function(response) {
                        console.log(response);
                        // Gunakan Swal.fire() untuk menampilkan SweetAlert
                        Swal.fire({
                            title: 'Pembayaran Expired',
                            text: 'Maaf, pembayaran anda telah expired. Silahkan lakukan pemesanan kembali.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#E74A3B',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Jika pengguna mengklik OK, kembali ke halaman sebelumnya
                                history.back();
                            }
                        });
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });

            }
        }, 1000);
    </script>
@endsection
