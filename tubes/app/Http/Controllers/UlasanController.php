<?php

namespace App\Http\Controllers;

use App\Models\Ulasan; // Import Model
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // PASTIKAN menggunakan Model Ulasan
        $ulasans = Ulasan::latest()->get();
        return view('ulasan.index', compact('ulasans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|sometimes',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500'
        ]);

        
        Ulasan::create([
        'id_customer' => $request->id_customer,
        'nama' => $request->nama,
        'email' => $request->email ?: '',
        'rating' => $request->rating,
        'komentar' => $request->komentar
    ]);

        return redirect()->route('ulasan.index')
            ->with('success', 'Ulasan berhasil dikirim!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500'
        ]);

        // Update menggunakan Model Ulasan
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->update($request->all());

        return redirect()->route('ulasan.index')
            ->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus menggunakan Model Ulasan
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return redirect()->route('ulasan.index')
            ->with('success', 'Ulasan berhasil dihapus!');
    }
}