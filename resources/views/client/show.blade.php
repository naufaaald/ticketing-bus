@extends('layouts.app')
@section('title', $id)
@section('styles')
    <style>
        a:hover {
            text-decoration: none;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12" style="">
            <a href="{{ url('/') }}" class="text-dark btn"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
            <div class="row mt-4">
                @if (count($dataRute) > 0)
                    @foreach ($dataRute as $data)
                        <div class="col-lg-12 mb-0">
                            @if ($data['kursi'] == 0)
                                <div class="card o-hidden border-0 shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="font-weight-bold text-muted text-uppercase mb-1">
                                                    {{ $data['tujuan'] }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-muted mb-1">{{ $data['start'] }} -
                                                    {{ $data['end'] }}</div>
                                                <small class="text-muted">{{ $data['transportasi'] }}
                                                    ({{ $data['kode'] }})
                                                </small>
                                            </div>
                                            <div class="col-auto text-right">
                                                <div class="h5 mb-0 font-weight-bold text-muted">Rp.
                                                    {{ number_format($data['harga'], 0, ',', '.') }}</div>
                                                <small class="text-muted">/Orang</small>
                                                <p class="text-muted font-weight-bold">Habis</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- <a href="{{ route('cari.kursi', Crypt::encrypt($data)) }}" id="card-tiket"></a> --}}
                                <div
                                    data-id="{{ $data['id'] }}"class="card-tiket card o-hidden border-0 shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="font-weight-bold text-gray-800 text-uppercase mb-1">
                                                    {{ $data['tujuan'] }} - 14:30</div>
                                                <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                    {{ $data['start'] }} - {{ $data['end'] }}</div>
                                                <small class="text-muted">{{ $data['transportasi'] }}
                                                    ({{ $data['kode'] }})</small>
                                            </div>
                                            <div class="col-auto text-right">
                                                <div class="h5 mb-0 font-weight-bold text-danger">Rp.
                                                    {{ number_format($data['harga'], 0, ',', '.') }}</div>
                                                <small class="text-muted">/Orang</small>
                                                @if ($data['kursi'] < 50)
                                                    <p class="text-danger" style="margin: 0;">
                                                        <small>{{ $data['kursi'] }} Kursi Tersedia</small>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-12 mb-4 mt-4">
                            <div class="form-input form-tiket-{{ $data['id'] }} card o-hidden border-0 shadow py-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            @include('client.kursi')
                                        </div>
                                        <div class="col-lg-6 col-12 my-3">
                                            <p class="font-weight-bold">Data Penumpang</p>
                                            <form id="form-buy-ticket-{{ $data['id'] }}" action="{{ route('pesan') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="idTiket" value="{{ $data['id'] }}">

                                                <input type="hidden" name="namaPenumpang"
                                                    id="hiddenNamaPenumpang-{{ $data['id'] }}">
                                                <input type="hidden" name="nomorKursi"
                                                    id="hiddenNomorKursi-{{ $data['id'] }}">
                                                <input type="hidden" name="harga" id="hiddenHarga-{{ $data['id'] }}">
                                                <input type="hidden" name="waktu" id="waktu-{{ $data['id'] }}"
                                                    value="{{ $data['waktu'] }}">
                                                <div class="form-group">
                                                    <label for="nama-penumpang">Nama Penumpang</label>
                                                    <input type="text" class="form-control" name="namaPenumpang"
                                                        id="nama-penumpang-{{ $data['id'] }}"
                                                        placeholder="Nama Penumpang">
                                                </div>
                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="use-user-data-{{ $data['id'] }}">
                                                    <label class="form-check-label" for="use-user-data">
                                                        Gunakan data pengguna
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nomor-telepon">Nomor Telepon</label>
                                                    <input type="text" class="form-control"
                                                        id="nomor-telepon-{{ $data['id'] }}" name="nomorTelepon"
                                                        placeholder="Nomor Telepon">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        id="email-{{ $data['id'] }}" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea class="form-control" rows="2" type="text" id="alamat-{{ $data['id'] }}" name="alamat"
                                                        placeholder="Alamat"></textarea>
                                                </div>
                                                <p class="font-weight-bold mt-3">Data Tiket</p>
                                                <div class="form-group">
                                                    <label for="nomor-kursi">Nomor Kursi</label>
                                                    <input type="text" class="form-control"
                                                        id="nomor-kursi-{{ $data['id'] }}" name="nomorKursi"
                                                        placeholder="Nomor Kursi" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="harga">Harga</label>
                                                    <input type="text" class="form-control"
                                                        id="harga-{{ $data['id'] }}" name="harga"
                                                        placeholder="Harga" disabled>
                                                </div>
                                                <div class="justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-success btn-block button-{{ $data['id'] }}">Submit</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 mb-4">
                        <div class="card o-hidden border-0 shadow h-100 py-2">
                            <div class="card-body text-center">
                                <h3 class="text-gray-900 font-weight-bold">Ticket tidak tersedia</h3>
                                <p class="text-muted">Ubah pencarian dengan data yang berbeda.</p>
                                <a href="{{ url('/') }}" class="btn btn-primary"
                                    style="font-size: 16px; border-radius: 10rem;">
                                    Ubah Pencarian
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
    </script>
    <script>
        // Ambil data pengguna dari variabel PHP
        let userData = @json($user);
        $(document).ready(function(e) {
            // Hide form tiket saat di load ;
            $('.form-input').css('display', 'none');
            // Toggle form tiket saat card tiket di klik
            $('.card-tiket').click(function() {
                let dataId = $(this).data('id');
                $('.form-tiket-' + dataId).toggle();

                $('#use-user-data-' + dataId).change(function(e) {
                    if (this.checked) {
                        $('#nama-penumpang-' + dataId).val(userData.name);
                        $('#nama-penumpang-' + dataId).prop('disabled', true);
                    } else {
                        $('#nama-penumpang-' + dataId).val('');
                        $('#nama-penumpang-' + dataId).prop('disabled', false);
                    }
                });
                // ketika submit baru jalankan validateform
                $('.button-' + dataId).click(function(e) {
                    //ambil semua value dari form
                    let namaPenumpang = document.getElementById('nama-penumpang-' + dataId).value;
                    let nomorTelepon = document.getElementById('nomor-telepon-' + dataId).value;
                    let email = document.getElementById('email-' + dataId).value;
                    let alamat = document.getElementById('alamat-' + dataId).value;
                    let nomorKursi = document.getElementById('nomor-kursi-' + dataId).value;
                    let harga = document.getElementById('harga-' + dataId).value;

                    $('#hiddenNamaPenumpang-' + dataId).val(namaPenumpang);
                    $('#hiddenNomorKursi-' + dataId).val(nomorKursi);
                    $('#hiddenHarga-' + dataId).val(harga);
                    let formData = {
                        namaPenumpang: namaPenumpang,
                        nomorTelepon: nomorTelepon,
                        email: email,
                        alamat: alamat,
                        nomorKursi: nomorKursi,
                        harga: harga
                    }
                    validateForm(dataId, formData);
                });

            });
        });

        function validateForm(dataId, formData) {
            event.preventDefault();
            // Ambil data dari form
            let formNamaPenumpang = formData.namaPenumpang;
            let formNomorTelepon = formData.nomorTelepon;
            let formEmail = formData.email;
            let formAlamat = formData.alamat;
            let formNomorKursi = formData.nomorKursi;
            let formHarga = formData.harga;
            if (formNomorKursi.trim() === '') {
                Swal.fire({
                    title: 'Warning',
                    text: 'Silakan pilih kursi terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#E74A3B',
                    customClass: {
                        // Ukuran teks pada sweet alert
                        content: 'text-size-10px'
                    }
                });
                return false;
            } else if (formHarga.trim() === '' || formNamaPenumpang.trim() === '' ||
                formNomorTelepon.trim() === '' || formEmail.trim() === '' || formAlamat.trim() === '') {
                Swal.fire({
                    title: 'Warning',
                    text: 'Silakan lengkapi data pesanan terlebih dahulu.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#E74A3B',
                    customClass: {
                        // Ukuran teks pada sweet alert
                        content: 'text-size-10px'
                    }
                });
                return false;
            } else {
                Swal.fire({
                    title: "Menunggu Proses Pesanan Anda",
                    text: 'Mohon tunggu sebentar, kami sedang memproses pesanan Anda.',
                    icon: 'info',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false, // Tidak menampilkan tombol OK
                    allowOutsideClick: false,
                    willClose: () => {
                        // Melakukan submit form setelah sweet alert ditutup
                        $('#form-buy-ticket-' + dataId).submit();
                    },
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                return true;
            }
        }
    </script>
@endsection
