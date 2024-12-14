<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Katalog;

class KatalogController extends Controller
{
    public function index()
    {
        $katalog = Katalog::all();
        return view('dashboard', compact('katalog'));
    }

    public function detail($id)
    {
        $katalog = Katalog::findOrFail($id); // Menemukan katalog berdasarkan id
        return view('detail', compact('katalog')); // Menampilkan view detail.blade.php
    }
    public function tentangKami()
    {
        // Tentang Kami page logic
        return view('dashboard.tentangkami');
    }

    public function katalog()
    {
        // Katalog page logic
        return view('dashboard.katalog');
    }
    
}