<!-- resources/views/transaksi.blade.php -->
@extends('layouts.navigation')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-6">Daftar Transaksi</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transaksis as $transaksi)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->katalog->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaksi->total_harga, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($transaksi->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaksi->additional }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
