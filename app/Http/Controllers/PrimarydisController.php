<?php

namespace App\Http\Controllers;

use App\Models\Primarydis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class PrimarydisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $primarydis = Primarydis::all();
        $fileName = $primarydis->unique . '_' . $primarydis->name;
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
            $image = true;
        } elseif (strtolower($fileExtension) === 'mp4') {
            $image = false;
        } else {
            $image = null;
        }
        return view('primarydisplay.index',[
            'primarydis' => $primarydis,
            'type' => $image
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('primarydisplay.create',[
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
        $mimeType = $file->getMimeType();

        // Tentukan folder berdasarkan jenis file
        $folder = '';
        if (str_starts_with($mimeType, 'image')) {
            $folder = 'upload/image'; // Folder untuk gambar
        } elseif (str_starts_with($mimeType, 'video')) {
            $folder = 'upload/video'; // Folder untuk video
        } else {
            return back()->with('error', 'File yang diunggah tidak didukung!');
        }

        // Pindahkan file ke folder yang sesuai
        $file->move(public_path($folder), $fileName);
        try {
            $primarydis = new Primarydis();
            
            // Update data
            $primarydis->unique = $unique;
            $primarydis->name = $filenameori;
            $primarydis->updated_by = Auth::user()->id;
            $primarydis->created_by = Auth::user()->id;
    
            // Simpan ke database
            $primarydis->save();
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
            $datadisplay = Primarydis::findOrFail($id);

            $fileName = $datadisplay->unique . '_' . $datadisplay->name;
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
                $filePath = public_path('upload/image/' . $fileName);
            } elseif (strtolower($fileExtension) === 'mp4') {
                $filePath = public_path('upload/video/' . $fileName);
            } else {
                $filePath = null; // Default jika file tidak dikenali
            }

            // Periksa apakah file ada
            if (File::exists($filePath)) {
                // Hapus file
                File::delete($filePath);
            }
            $datadisplay->delete();
            return redirect()->route('primarydisplay.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('primarydisplay.index', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }
}
