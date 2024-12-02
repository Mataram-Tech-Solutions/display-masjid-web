<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kajian;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ulama = Ustadz::get();
        return view('ulama.index', [
            'ulama' => $ulama,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ulama.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nama = $request->input('nama');
        $gender = $request->input('gender');
        try {
            $ulama = new Ustadz();
            
            // Update data
            $ulama->name = $nama;
            $ulama->ustd = $gender;
            $ulama->updated_by = Auth::user()->id;
            $ulama->created_by = Auth::user()->id;
    
            // Simpan ke database
            $ulama->save();
            return redirect()->route('ulama.index')->with('success', 'Berhasil menambahkan jadwal!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('ulama.create')->with('error', 'Terjadi kesalahan dari server!');
            }
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
        $oldval = Ustadz::findOrFail($id);
        return view('ulama.edit', [
            'oldval' => $oldval,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nama = $request->input('nama');
        $gender = $request->input('gender');
        try {
            $ulama = Ustadz::findOrFail($id);
            
            // Update data
            $ulama->name = $nama;
            $ulama->ustd = $gender;
            $ulama->updated_by = Auth::user()->id;
    
            // Simpan ke database
            $ulama->save();
            return redirect()->route('ulama.index')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('ulama.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ulama = Ustadz::findOrFail($id);
            $kajian = Kajian::where('ulama', $id)->get();
            Kajian::where('ulama', $id)->update(['ulama' => null]);
            Jadwal::where('imam', $id)->update(['imam' => null]);
            Jadwal::where('khatib', $id)->update(['khatib' => null]);
            $ulama->delete();
            return redirect()->route('ulama.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('ulama.index', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }
}
