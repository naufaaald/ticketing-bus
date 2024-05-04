@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12" style="margin-top: -15px">
            <a href="{{ url('/') }}" class="text-white btn"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
            <div class="row mt-2">
                <div class="col-12 mb-4">
                    <div class="card o-hidden border-0 shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="font-weight-bold text-gray-800 text-uppercase mb-1">
                                    Pembayaran
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-7 mb-4">
                        <div class="card o-hidden border-0 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                            Kirim Ke Nomor Rekening Berikut
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <small class="text-muted text-uppercase">Bank BCA</small>
                                                <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                    1234567890
                                                </div>
                                            </div>
                                            <div class="col">
                                                <span class="text-dark">
                                                    <b> Muhammad Naufal Defriandi</b>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <small class="text-muted text-uppercase">Bank BCA</small>
                                                <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                    1234567890
                                                </div>
                                            </div>
                                            <div class="col">
                                                <span class="text-dark">
                                                    <b> Muhammad Naufal Defriandi</b>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row justify-content-between mb-3">
                                            <div class="col">
                                                <small class="text-muted text-uppercase">Bank BCA</small>
                                                <div class="h5 mb-0 font-weight-bold text-danger mb-1">
                                                    1234567890
                                                </div>
                                            </div>
                                            <div class="col">
                                                <span class="text-dark">
                                                    <b> Muhammad Naufal Defriandi</b>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                            Upload Bukti Pembayaran
                                        </div>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
                                                <input type="file" class="form-control" id="bukti_pembayaran"
                                                    name="bukti_pembayaran">
                                            </div>
                                            <div class="d-block">
                                                <button type="submit" class="btn btn-primary ">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card o-hidden border-0 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                        Detail Pesanan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-7 mb-4">
            <div class="card o-hidden border-0 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-gray-800 text-uppercase mb-3">
                                Data Penumpang
                            </div>
                            <div class="row justify-content-between mb-2">
                                <div class="col">
                                    Nama Penumpang
                                </div>
                                <div class="col">
                                    Muhammad Naufal Defriandi
                                </div>
                            </div>
                            <div class="row justify-content-between mb-2">
                                <div class="col">
                                    Nomor Telepon
                                </div>
                                <div class="col">
                                    081254546565
                                </div>
                            </div>
                            <div class="row justify-content-between mb-2">
                                <div class="col">
                                    Alamat
                                </div>
                                <div class="col">
                                    Jl. Jendral Sudirman No. 123 Bukittinggi
                                </div>
                            </div>
                            <div class="row justify-content-between mb-2">
                                <div class="col">
                                    Email
                                </div>
                                <div class="col">
                                    naufal@gmail.com
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
