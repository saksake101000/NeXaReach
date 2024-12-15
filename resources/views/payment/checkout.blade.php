@extends('layouts.navigation')

@section('content')
<div class="container">
    <h1>Checkout Pembayaran</h1>

    <!-- Menampilkan total harga transaksi -->
    <p><strong>Total Pembayaran:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
    <p><strong>Order ID:</strong> {{ $transaksi->id }}</p>

    <!-- Tombol untuk memulai pembayaran menggunakan Midtrans -->
    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
</div>

<!-- Load Snap.js dari Midtrans -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        // Mengambil Snap Token yang telah disiapkan oleh controller
        snap.pay("{{ $transaksi->snap_token }}", {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                console.log(result);
                // Bisa diarahkan ke halaman konfirmasi atau transaksi berhasil
                window.location.href = "{{ route('transaksi.index') }}";
            },
            onPending: function(result) {
                alert("Pembayaran pending. Harap menunggu konfirmasi.");
                console.log(result);
            },
            onError: function(result) {
                alert("Terjadi kesalahan dalam pembayaran.");
                console.log(result);
            }
        });
    };
</script>
@endsection