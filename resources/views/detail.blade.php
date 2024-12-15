@extends('layouts/navigation')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <!-- Header Produk -->
            <div class="text-center mb-8">
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ $katalog->nama }}
                </h2>
            </div>
            <!-- Gambar dan Detail Produk -->
            <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-6">
                <img src="{{ asset('storage/' . $katalog->gambar) }}" 
                     alt="{{ $katalog->nama }}" 
                     class="w-full max-w-sm md:max-w-md h-auto object-contain rounded-md shadow-md">
                <div class="mt-6 md:mt-0 flex-1">
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $katalog->nama }}</h3>
                    <p class="mt-4 text-gray-600">{{ $katalog->deskripsi }}</p>
                    <p class="mt-4 text-xl font-bold text-gray-800">Rp {{ number_format($katalog->harga, 2, ',', '.') }}</p>
                </div>
            </div>
            <!-- Form untuk Membuat Transaksi -->
            <div class="mt-10">
            <form action="{{ route('transaksi.store') }}" method="POST" class="bg-white p-6 ">
                @csrf <!-- Token keamanan Laravel -->
                <input type="hidden" name="katalog_id" value="{{ $katalog->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <div class="mb-4">
                    <label for="additional" class="block text-sm font-medium text-gray-700 text-center">Catatan Tambahan</label>
                    <textarea name="additional" id="additional" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            rows="4"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Order
                    </button>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>

@endsection