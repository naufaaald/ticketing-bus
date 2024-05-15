<div class="col-12 col-lg-12 text-center">
    <p class="text-muted text-1">Click on Seat to select/ deselect</p>
    <div class="seat-map-{{ $data['id'] }}" data-id="{{ $data['id'] }}" data-kursi="{{ $data['dataPesanan'] }}">
        <div class="front-indicator">Front</div>
    </div>
    <div class="legend-{{ $data['id'] }}"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Seat Charts
        // Definisikan variabel map dengan format peta kursi
        let map = [
            'ff_ff',
            'ff_ff',
            'ff_ff',
            'ff_ff',
            'ff_ff',
            'ff_ff',
            'ff_ff',
            'ff_ff',
            'ff_ff',
        ];

        let seatNumber = 1;
        let seatSelected = null;
        let dataId = $('.seat-map-{{ $data['id'] }}').data('id');
        let $cart = $('#nomor-kursi-{{ $data['id'] }}'),
            $seatMap = $('.seat-map-{{ $data['id'] }}');
        let sc = $seatMap.seatCharts({
            map: map,
            seats: {
                f: {
                    price: 175000,
                    classes: 'first-class', //your custom CSS class
                    category: 'First Class'
                },
            },
            naming: {
                top: false,
                getLabel: function(character, row, column) {
                    return seatNumber++;
                },
            },
            legend: {
                node: $('.legend-{{ $data['id'] }}'),
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
                        $('#harga-{{ $data['id'] }}').val('Rp. ' + formatNumber(price));

                        return 'selected';
                    } else {
                        // Jika sudah ada kursi yang dipilih, tampilkan pesan peringatan
                        swal.fire({
                            title: 'Warning',
                            text: 'Maaf, Anda hanya dapat memilih satu kursi. Silakan batalkan pemilihan kursi sebelumnya terlebih dahulu.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#E74A3B',
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
                        $('#harga-{{ $data['id'] }}').val('');

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

        let dataPesanan = $('.seat-map-{{ $data['id'] }}').data('kursi');

        // Fungsi untuk mengonversi nomor kursi menjadi baris dan kolom
        function convertSeatNumberToRowColumn(seatNumber, totalColumns) {
            let row = Math.ceil(seatNumber / totalColumns); // Hitung baris berdasarkan nomor kursi
            let column = seatNumber % totalColumns; // Hitung kolom berdasarkan nomor kursi

            // Handle jika nomor kursi habis dibagi jumlah kolom
            if (column === 0) {
                column = totalColumns;
            }
            if (column === 3) {
                column += 1;
            } else
            if (column === 4) {
                column += 1;
            }
            return {
                row,
                column
            };
        }
        // Contoh penggunaan
        let totalColumns = 4; // Jumlah kolom pada peta kursi
        // let seatsBooked = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
        // 14]; 

        // Ubah format nama kursi
        let convertedSeats = dataPesanan.map(seat => {
            let {
                row,
                column
            } = convertSeatNumberToRowColumn(seat, totalColumns);
            return `${row}_${column}`; // Format kursi menjadi 'baris_kolom'

        });
        sc.get(convertedSeats).status('unavailable');

    });
</script>
<script>
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    }
</script>
