<?php

namespace App\Http\Controllers;

use App\Models\Muharram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MuharramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $muh = Muharram::get();
        return view('muharram.index',[
            'muharram' => $muh,
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
        $oldval = Muharram::findOrFail($id);
        return view('muharram.edit', [
            'oldval' => $oldval,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tanggalmuh = $request->input('tanggalmuh');
        $hijriyahke = $request->input('tahunke');
        try {
            $muharram = Muharram::findOrFail($id);
            
            // Update data
            $muharram->tanggalmuh = $tanggalmuh;
            $muharram->muhke = $hijriyahke;
            $muharram->updated_by = Auth::user()->id;
    
            // Simpan ke database
            $muharram->save();
            return redirect()->route('muharram.index')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('muharram.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
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
