<div class="row justify-content-center">
    <div class="col-12" style="margin-top: -15px">
        <a href="javascript:window.history.back();" class="text-white btn"><i class="fas fa-arrow-left mr-2"></i>
            Kembali</a>
        <div class="row">
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
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email">
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
            </div>


            <script>
                document.addEventListener("DOMContentLoaded", () => {
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
