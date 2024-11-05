<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    // Menampilkan halaman voting beserta hasil voting
    public function index()
    {
        $options = Option::all();  // Ambil semua opsi voting
        return view('vote.index', compact('options'));
    }

    // Menangani form vote
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'option_id' => 'required|exists:options,id',  // Validasi id opsi yang dipilih
        ]);

        // Cari opsi berdasarkan ID yang dipilih
        $option = Option::find($request->option_id);
        
        // Increment jumlah suara untuk opsi tersebut
        $option->increment('vote_count');
        
        // Ambil opsi yang memiliki suara terbanyak untuk ditampilkan di popup
        $options = Option::all();
        $selectedOption = $option;  // Opsi yang dipilih pengguna

        // Mengembalikan hasil vote beserta pesan sukses dan data opsi yang dipilih
        return redirect()->route('vote.index')->with(['success' => 'Terima kasih telah memberikan suara Anda!', 'selectedOption' => $selectedOption, 'options' => $options]);
    }
}
