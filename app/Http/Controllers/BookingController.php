<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // VALIDASI INPUT
        $validated = $request->validate([
            'nama'  => 'required|string|max:100',
            'nim'   => 'required|digits:10', // NIM harus 10 digit angka
            'paket' => 'required|string'
        ]);

        try {
            // POINT-TO-POINT: CALL SERVICE B (PORT 8001)
            $response = Http::timeout(5)->get(
                'http://localhost:8001/api/assets/package/' . $validated['paket']
            );

            // ERROR HANDLING JIKA SERVICE B GAGAL
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Gagal mengambil data dari Service B',
                ], 500);
            }

            $dataPaket = $response->json();

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Service B tidak aktif / tidak bisa diakses',
                'message' => $e->getMessage()
            ], 500);
        }

        // RESPONSE SUKSES
        return response()->json([
            'message'      => 'Booking berhasil',
            'peminjam'     => $validated['nama'],
            'nim'          => $validated['nim'],
            'paket'        => $validated['paket'],
            'detail_paket' => $dataPaket
        ], 201);
    }
}
