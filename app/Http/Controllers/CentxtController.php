<?php

namespace App\Http\Controllers;

use App\Events\Hadist;
use App\Models\Centxt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentxtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centxt = Centxt::all();
        return view('centxt.index', [
            'centxt' => $centxt,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('centxt.create',[
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $arti = $request->input('txt');
        try {
            $modelcentxt = new Centxt();
            
            // Update data
            $modelcentxt->txt = $arti;
            $modelcentxt->updated_by = Auth::user()->id;
            $modelcentxt->created_by = Auth::user()->id;
    
            // Simpan ke database
            $modelcentxt->save();
            event(new Hadist(Centxt::all()));
            return redirect()->route('centxt.index')->with('success', 'Berhasil menambahkan jadwal!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('centxt.create')->with('error', 'Terjadi kesalahan dari server!');
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
        $oldval = Centxt::findOrFail($id);
        return view('centxt.edit', [
            'oldval' => $oldval,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $arti = $request->input('txt');
        try {
            $modelcentxt = Centxt::findOrFail($id);
            
            // Update data
            $modelcentxt->txt = $arti;
            $modelcentxt->updated_by = Auth::user()->id;
    
            // Simpan ke database
            $modelcentxt->save();
            return redirect()->route('centxt.index')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('centxt.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $centxtmodel = Centxt::findOrFail($id);
            $centxtmodel->delete();
            return redirect()->route('centxt.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('centxt.index', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }
}
