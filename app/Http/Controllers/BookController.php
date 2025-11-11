<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookLoan;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    /**
     * Menampilkan form peminjaman buku
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Menyimpan data peminjaman buku
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'buku_dipinjam' => 'required|string',
            'tanggal_peminjaman' => 'required|date_format:d-m-Y',
            'tanggal_pengembalian' => 'required|date_format:d-m-Y|after:tanggal_peminjaman',
        ], [
            'nama.required' => 'Nama harus diisi.',
            'nim.required' => 'NIM harus diisi.',
            'buku_dipinjam.required' => 'Pilih buku yang akan dipinjam.',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi.',
            'tanggal_peminjaman.date_format' => 'Format tanggal peminjaman tidak sesuai.',
            'tanggal_pengembalian.required' => 'Tanggal pengembalian harus diisi.',
            'tanggal_pengembalian.date_format' => 'Format tanggal pengembalian tidak sesuai.',
            'tanggal_pengembalian.after' => 'Tanggal pengembalian harus setelah tanggal peminjaman.',
        ]);

        // Simpan data ke database
        // BookLoan::create($validatedData);

        return back()->with('success', 'Peminjaman buku berhasil diajukan!');
    }
}
