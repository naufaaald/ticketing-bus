@extends('layouts.app')
@section('title', 'Cari Kursi')
@section('styles')
    <link href="{{ asset('css/jquery.seat-charts.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12" style="margin-top: -15px">
            <a href="javascript:window.history.back();" class="text-white btn"><i class="fas fa-arrow-left mr-2"></i>
                Kembali</a>
            <div class="row" style="margin-top: 100px ">
                {{-- @for ($i = 1; $i <= $transportasi->jumlah; $i++)
                    @php
                        $array = ['kursi' => 'K' . $i, 'rute' => $data['id'], 'waktu' => $data['waktu']];
                        $cekData = json_encode($array);
                    @endphp
                    @if ($transportasi->kursi($cekData) != null)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                            <a href="{{ route('pesan', ['kursi' => 'K' . $i, 'data' => Crypt::encrypt($data)]) }}">
                                <div class="kursi bg-white">
                                    <div class="font-weight-bold text-primary m-auto" style="font-size: 26px;">
                                        K{{ $i }}</div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                            <div class="kursi" style="background: #858796">
                                <div class="font-weight-bold text-white m-auto" style="font-size: 26px;">
                                    K{{ $i }}</div>
                            </div>
                        </div>
                    @endif
                @endfor --}}

                <div class="col-lg-6 text-center col-12 ">
                    <div class="col-12 col-lg-12 ">
                        <p class="text-muted text-1">Click on Seat to select/ deselect</p>
                        <div id="seat-map">
                            <div class="front-indicator">Front</div>
                        </div>
                        <div id="legend"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mt-3">
                    <p class="font-weight-bold">Data Penumpang</p>
                    <form>
                        <div class="form-group">
                            <label for="passenger-name">Nama Penumpang</label>
                            <input type="text" class="form-control" id="passenger-name" placeholder="Nama Penumpang">
                        </div>
                        <div class="form-group">
                            <label for="phone-number">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone-number" placeholder="Nomor Telepon">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" rows="2" type="text" id="address" placeholder="Alamat">
                            </textarea>
                        </div>
                        <p class="font-weight-bold mt-3">Data Tiket</p>
                        <div class="form-group">
                            <label for="seat-number">Nomor Kursi</label>
                            <input type="text" class="form-control" id="seat-number" placeholder="Nomor Kursi" disabled>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="text" class="form-control" id="price" placeholder="Harga" disabled>
                        </div>
                        <div class="justify-content-end">

                            <a class="btn btn-primary" href="{{ route('pembayaran.create') }}">Submit</a>


                        </div>


                    </form>
                @endsection
                @section('script')
                    <script src="{{ asset('js/jquery.seat-charts.min.js') }}"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            // Seat Charts
                            let seatNumber = 1;
                            let seatSelected = null;
                            let $cart = $('#seat-number'),
                                $seatMap = $('#seat-map');
                            let sc = $seatMap.seatCharts({
                                map: [
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',
                                    'ff_ff',

                                ],
                                seats: {
                                    f: {
                                        price: 175000,
                                        classes: 'first-class', //your custom CSS class
                                        category: 'First Class'
                                    },
                                },
                                naming: {
                                    top: false,
                                    getLabel: function(character, row) {
                                        return seatNumber++;
                                    },

                                },
                                legend: {
                                    node: $('#legend'),
                                    items: [
                                        ['f', 'available', 'First Class'],
                                        ['f', 'unavailable', 'Already Booked']
                                    ]
                                },
                                click: function() {
                                    if (this.status() === 'available') {
                                        //let's create a new <li> which we'll add to the cart items
                                        if (seatSelected === null) {
                                            seatSelected = this.settings.label;
                                            let seat = this.settings.label;
                                            let price = this.data().price;
                                            // Tambahkan kursi yang dipilih ke dalam form seat number
                                            $cart.val(seat);
                                            // tambahkan harga kursi ke dalam form price
                                            $('#price').val('Rp. ' + formatNumber(price));

                                            return 'selected';
                                        } else {
                                            // Jika sudah ada kursi yang dipilih, tampilkan pesan peringatan
                                            swal.fire({
                                                title: 'Warning',
                                                text: 'Maaf, Anda hanya dapat memilih satu kursi. Silakan batalkan pemilihan kursi sebelumnya terlebih dahulu.',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                confirmButtonColor: '#35709C',
                                                textSize: '10px'
                                            });
                                            return this.status();
                                        }
                                    } else if (this.status() === 'selected') {
                                        if (seatSelected === this.settings.label) {
                                            // Jika kursi yang dipilih sebelumnya adalah kursi yang sama dengan yang saat ini dipilih, batalkan pemilihan
                                            seatSelected = null;
                                            // Hapus kelas 'selected' dari kursi yang dipilih
                                            this.status('available');
                                            // hapus data di form
                                            $cart.val('');
                                            $('#price').val('');

                                            return 'available';
                                        } else {
                                            // Jika kursi yang dipilih sebelumnya bukan kursi yang sama, tampilkan pesan peringatan
                                            alert('Anda hanya dapat memilih satu kursi.');
                                            return this.status();
                                        }
                                    } else if (this.status() === 'unavailable') {
                                        //seat has been already booked
                                        return 'unavailable';
                                    } else {
                                        return this.style();
                                    }
                                }
                            });




                        });
                    </script>
                    <script>
                        function formatNumber(num) {
                            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                        }
                    </script>
                @endsection
