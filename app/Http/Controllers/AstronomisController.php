<?php

namespace App\Http\Controllers;

use App\Models\Astronomis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AstronomisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Astronomis::with(['waktuWilayah'])->get();          
        return view('astronomis.index', [
            'dataIndex' => $data,
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
        $oldval = Astronomis::findOrFail($id);
        return view('astronomis.edit', [
            'oldval' => $oldval,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $ketinggian_laut = $request->input('ketinggian_laut');
        $sudut_fajarsenja = $request->input('sudut_fajarsenja');
        $sudut_malamsenja = $request->input('sudut_malamsenja');
        $zonaWaktu = $request->input('gmt'); 
        try {
            $astronomis = Astronomis::findOrFail($id);
            
            // Update data
            $astronomis->latitude = $latitude;
            $astronomis->longitude = $longitude;
            $astronomis->ketinggian_laut = $ketinggian_laut;
            $astronomis->sudut_fajarsenja = $sudut_fajarsenja;
            $astronomis->sudut_malamsenja = $sudut_malamsenja;
            $astronomis->gmt = $zonaWaktu;
            $astronomis->updated_by = Auth::user()->id;
    
            // Simpan ke database
            $astronomis->save();
            return redirect()->route('astronomis.index')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('astronomis.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
