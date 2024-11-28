<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use Illuminate\Http\Request;

class JadwalKajianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kajian = Kajian::with(['pemateri'])->get();            
        return view('jadwalKajian.index', [
            'kajian' => $kajian,

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
        try {
        $kajian = Kajian::findOrFail($id);
        $kajian->delete();
        return redirect()->route('jadwalkajian.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            // Redirect ke edit jika gagal dengan pesan error
            return redirect()->route('jadwalkajian.index', $id)->with('error', 'Terjadi kesalahan dari server!');
        }
    }
}
