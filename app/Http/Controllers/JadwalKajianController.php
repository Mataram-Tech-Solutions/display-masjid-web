<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $ulama = Ustadz::get();
        return view('jadwalKajian.create', [
            'ulama' => $ulama
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $judul = $request->input('judul');
        $pemateri = $request->input('ulama');
        $tgl_pelaksanaan = $request->input('pelaksanaan_date');
        $pelaksanaanjam = $request->input('pelaksanaan_hour');
        $pelaksanaanmenit = $request->input('pelaksanaan_minute');
        try {
            $kajian = new Kajian();
            
            // Update data
            $kajian->judul = $judul;
            $kajian->ulama = $pemateri;
            $kajian->tgl_pelaksanaan = sprintf('%s %02d:%02d:00', $tgl_pelaksanaan, $pelaksanaanjam, $pelaksanaanmenit);
            $kajian->updated_by = Auth::user()->id;
            $kajian->created_by = Auth::user()->id;
    
            // Simpan ke database
            $kajian->save();
            return redirect()->route('jadwalkajian.index')->with('success', 'Berhasil menambahkan jadwal!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('jadwalkajian.create')->with('error', 'Terjadi kesalahan dari server!');
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
        $oldval =  Kajian::with('pemateri')->find($id);
        $ulama = Ustadz::get();
        return view('jadwalKajian.edit', [
            'oldval' => $oldval,
            'ulama' => $ulama
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $judul = $request->input('judul');
        $pemateri = $request->input('ulama');
        $tgl_pelaksanaan = $request->input('pelaksanaan_date');
        $pelaksanaanjam = $request->input('pelaksanaan_hour');
        $pelaksanaanmenit = $request->input('pelaksanaan_minute');
        try {
            $kajian = Kajian::findOrFail($id);
            
            // Update data
            $kajian->judul = $judul;
            $kajian->ulama = $pemateri;
            $kajian->tgl_pelaksanaan = sprintf('%s %02d:%02d:00', $tgl_pelaksanaan, $pelaksanaanjam, $pelaksanaanmenit);
            $kajian->updated_by = Auth::user()->id;
    
            // Simpan ke database
            $kajian->save();
            return redirect()->route('jadwalkajian.index')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('jadwalkajian.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
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
