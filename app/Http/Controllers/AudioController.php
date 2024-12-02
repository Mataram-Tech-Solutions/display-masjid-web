<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audio = Audio::all();
        return view('audio.index',[
            'audio' => $audio,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('audio.create',[
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $unique = time();
        $file = $request->file('file');
        $filenameori = $request->file('file')->getClientOriginalName();

        $fileName = $unique . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/audio'), $fileName);
        try {
            $audiomodel = new Audio();
            
            // Update data
            $audiomodel->unique = $unique;
            $audiomodel->name = $filenameori;
            $audiomodel->updated_by = Auth::user()->id;
            $audiomodel->created_by = Auth::user()->id;
    
            // Simpan ke database
            $audiomodel->save();
            return redirect()->route('audio.index')->with('success', 'Berhasil menambahkan jadwal!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('audio.create')->with('error', 'Terjadi kesalahan dari server!');
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
            $kajian = Audio::findOrFail($id);
            $kajian->delete();
            return redirect()->route('audio.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('audio.index', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }
}
