<div>
    @push('page-styles')
        <link href="{{ asset('assets/css/jquery.seat-charts.css') }}" rel="stylesheet" />
    @endpush
    @push('before-scripts')
        <script src="{{ asset('assets/js/jquery.seat-charts.min.js') }}"></script>
    @endpush
    <div class="row">
        <div class="col-12 col-lg-12 text-center">
            <p class="text-muted text-1">Click on Seat to select/ deselect</p>
            <div id="seat-map" wire:ignore>
                <div class="front-indicator">Front</div>
            </div>
            <div id="legend"></div>
        </div>
    </div>
    @push('livewire-script')
        <script>
            document.addEventListener('livewire:load', function() {
                // Seat Charts

                let seatSelected = null;
                let $cart = $('#selected-seats'),
                    $seatMap = $('#seat-map');
                let sc = $seatMap.seatCharts({
                    map: [
                        'f_s',
                        'd_f',
                        'f_f',
                        'f_f',
                        'f_f',
                        'f_f',
                        'f_f',
                    ],
                    seats: {
                        f: {
                            price: 15000,
                            classes: 'first-class', //your custom CSS class
                            category: 'First Class'
                        },
                        s: {
                            price: 0,
                            classes: 'driver', //your custom CSS class
                            category: 'Driver',
                            status: 'driver'
                        },
                        d: {
                            price: 0,
                            classes: 'door', //your custom CSS class
                            category: 'Door',
                            status: 'door'
                        }
                    },
                    naming: {
                        top: false,
                        getLabel: function(character, row, column) {
                            return row + column;
                        },
                        columns: ['A', '', 'B'],
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
                                Livewire.emit('seatSelect', seat);
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
                                // Mengirimkan sinyal ke Livewire untuk menunjukkan bahwa kursi telah dibatalkan
                                Livewire.emit('seatDeselect', this.settings.label);
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
                sc.get('2_A').status('door');
                sc.get('1_B').status('driver');

                // Temukan elemen HTML yang mewakili kursi
                let sopir = document.getElementById('1_B');
                let pintu = document.getElementById('2_A');

                // Ubah teks pada elemen kursi
                // Misalnya, mengubah teks menjadi "Sopir"
                // Buat elemen img untuk logo stripe
                let imgElement = document.createElement('img');
                imgElement.src = "{{ asset('assets/img/steering-wheel.svg') }}";
                imgElement.width = 30; // Lebar gambar (dalam piksel)
                imgElement.height = 25;
                // Ganti dengan path gambar logo stripe yang ingin Anda gunakan

                // Hapus semua konten teks pada elemen kursi
                sopir.innerText = '';

                // Tambahkan elemen img ke dalam elemen kursi
                sopir.appendChild(imgElement);

                pintu.innerText = 'Exit'; // Misalnya, mengubah teks menjadi "Sopir"

                //this will handle "[cancel]" link clicks
                $cart.on('click', '.cancel-cart-item', function() {
                    //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
                    sc.get($(this).parents('li:first').data('seatId')).click();
                });
                //let's pretend some seats have already been booked
                Livewire.on('seatSelected', function(seat) {
                    seatSelected = seat.seatPassenger;
                    seat.seatTicket.forEach(function(seat) {
                        let row = seat.substring(0, seat.length - 1); // Ambil nomor baris
                        let column = seat.substring(seat.length - 1); // Ambil huruf kursi
                        sc.get(row + '_' + column).status('unavailable'); // Tambahkan kursi ke chart
                    });
                    // Memeriksa apakah kursi penumpang ada di dalam daftar kursi keseluruhan
                    if (seat.seatTicket.includes(seat.seatPassenger)) {
                        let row = seat.seatPassenger.substring(0, seat.seatPassenger.length -
                            1); // Ambil nomor baris
                        let column = seat.seatPassenger.substring(seat.seatPassenger.length -
                            1); // Ambil huruf kursi
                        sc.get(row + '_' + column).status(
                            'selected'); // Tandai kursi penumpang sebagai dipilih (selected)

                    }
                });

                Livewire.on('seatClosed', function() {
                    sc.find('unvailable').status('available');
                });

                Livewire.on('seatDataToHistoryTransaksi', function(seat) {

                    seat.forEach(function(seat) {
                        let row = seat.substring(0, seat.length - 1); // Ambil nomor baris
                        let column = seat.substring(seat.length - 1); // Ambil huruf kursi
                        sc.get(row + '_' + column).status('unavailable'); // Tambahkan kursi ke chart
                    });

                });
            });
        </script>
    @endpush
</div>
