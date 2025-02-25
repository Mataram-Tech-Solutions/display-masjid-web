<?php

namespace App\Http\Controllers;

use App\Events\Runtxt as eventRun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Runtxt;


class RuntxtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $runtxt = Runtxt::all();
        event(new eventRun(Runtxt::all()));
        return view('runtxt.index', [
            'runtxt' => $runtxt,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('runtxt.create',[
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $text = $request->input('running');
        try {
            $modelruntxt = new Runtxt();
            
            // Update data
            $modelruntxt->txt = $text;
            $modelruntxt->updated_by = Auth::user()->id;
            $modelruntxt->created_by = Auth::user()->id;
    
            // Simpan ke database
            $modelruntxt->save();
            return redirect()->route('runtxt.index')->with('success', 'Berhasil menambahkan jadwal!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('runtxt.create')->with('error', 'Terjadi kesalahan dari server!');
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
        $oldval = Runtxt::findOrFail($id);
        return view('runtxt.edit', [
            'oldval' => $oldval,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $text = $request->input('running');
        try {
            $modelruntxt = Runtxt::findOrFail($id);
            
            // Update data
            $modelruntxt->txt = $text;
            $modelruntxt->updated_by = Auth::user()->id;
    
            // Simpan ke database
            $modelruntxt->save();
            return redirect()->route('runtxt.index')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('runtxt.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $runtxtmodel =Runtxt::findOrFail($id);
            $runtxtmodel->delete();
            return redirect()->route('runtxt.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('runtxt.index', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }
}
