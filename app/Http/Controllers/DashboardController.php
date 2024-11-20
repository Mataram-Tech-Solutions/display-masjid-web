<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jam = Jadwal::pluck('waktu_adzan');
        $jadwals = Jadwal::with(['ustadz', 'khatib'])->get();
        

        // Modifikasi data jadwal setelah didapatkan
        // $jadwals = $jadwals->map(function ($jadwal) {
        //     // Jika khatib kosong dan bukan Dzuhur, set khatib menjadi null
        //     if (is_null($jadwal->khatib) && $jadwal->shalat !== 'Dzuhur') {
        //         $jadwal->khatib = null;
        //     }
        //     return $jadwal;
        // });
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $jadwals
        // ], 200);  
        return view('dashboard', [
            'jam' => $jam,
            'jadwal' => $jadwals,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
