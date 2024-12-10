<?php

namespace App\Http\Controllers;

use App\Events\Hadist;
use App\Events\PrimarydisUpdated;
use App\Events\ProfileMasjid;
use App\Events\TanggalIslam;
use App\Models\Centxt;
use App\Models\Masjid;
use App\Models\Primarydis;
use Carbon\Carbon;
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
        event(new PrimarydisUpdated(Primarydis::all()));
        event(new Hadist(Centxt::all()));
        event(new ProfileMasjid(Masjid::all()));
        $muharramStart = Carbon::create(2024, 7, 7);

        // Nama bulan Islam
        $islamicMonths = [
            'Muharram',
            'Safar',
            'Rabiul Awwal',
            'Rabiul Akhir',
            'Jumadil Awwal',
            'Jumadil Akhir',
            'Rajab',
            'Sya\'ban',
            'Ramadhan',
            'Syawal',
            'Dzulqaidah',
            'Dzulhijjah'
        ];

        // Panjang bulan Hijriah dalam satu tahun
        $islamicMonthLengths = [29, 30, 30, 30, 29, 30, 30, 29, 29, 30, 29, 29];

        // Tanggal sekarang
        Carbon::setLocale('id');
        $currentDate = Carbon::now();

        // Hitung selisih hari dari 1 Muharram
        $daysDifference = $muharramStart->diffInDays($currentDate, false);

        // Jika sebelum 1 Muharram
        if ($daysDifference < 0) {
            return "Tanggal sekarang sebelum 1 Muharram 1446 H.";
        }

        // Mulai hitung bulan dan tanggal Hijriah
        $currentYear = 1446; // Tahun Hijriah awal
        $currentMonthIndex = 0; // Indeks bulan pertama (Muharram)
        $remainingDays = $daysDifference;

        // Iterasi untuk menghitung bulan Hijriah berdasarkan panjang bulan
        while ($remainingDays >= $islamicMonthLengths[$currentMonthIndex]) {
            $remainingDays -= $islamicMonthLengths[$currentMonthIndex];
            $currentMonthIndex++;

            // Jika melewati bulan Dzulhijjah, reset ke Muharram dan tambah tahun
            if ($currentMonthIndex >= 12) {
                $currentMonthIndex = 0;
                $currentYear++;
            }
        }

        // Tanggal dalam bulan Hijriah saat ini
        $currentHijriDate = $remainingDays + 1;
        $currentMonth = $islamicMonths[$currentMonthIndex];

        // Tampilkan hasil
        $data = [
            'tglHijriah' => $currentHijriDate . ' ' . $currentMonth . ' ' . $currentYear . ' H',
            'tglBiasa' => $currentDate->isoFormat('dddd, D MMMM YYYY')
        ];
        event(new TanggalIslam($data));
        $primarydis = Primarydis::all();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $primarydis
        // ], 200);  
        return view('primarydisplay.index',[
            'primarydis' => $primarydis,
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
            $primarydis->mime = $mimeType;
            $primarydis->updated_by = Auth::user()->id;
            $primarydis->created_by = Auth::user()->id;
    
            // Simpan ke database
            $primarydis->save();
            event(new PrimarydisUpdated(Primarydis::all()));
            return redirect()->route('primarydisplay.index')->with('success', 'Berhasil menambahkan jadwal!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('primarydisplay.create')->with('error', 'Terjadi kesalahan dari server!');
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
            event(new PrimarydisUpdated(Primarydis::all()));

            return redirect()->route('primarydisplay.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('primarydisplay.index', $id)->with('error', 'Terjadi kesalahan dari server!');
            }
    }
}
