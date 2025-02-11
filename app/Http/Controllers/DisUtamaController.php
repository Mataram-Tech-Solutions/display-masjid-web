<?php

namespace App\Http\Controllers;

use App\Events\Hadist;
use App\Events\Jdwlkaj;
use App\Events\Jdwlsho;
use App\Events\PrimarydisUpdated;
use App\Events\ProfileMasjid;
use App\Events\Runtxt;
use App\Events\TanggalIslam;
use App\Models\Centxt;
use App\Models\Jadwal;
use App\Models\Kajian;
use App\Models\Masjid;
use App\Models\Primarydis;
use App\Models\Runtxt as ModelsRuntxt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DisUtamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // event(new PrimarydisUpdated(Primarydis::all()));
        // event(new Hadist(Centxt::all()));
        // event(new ProfileMasjid(Masjid::all()));
        // event(new Hadist(Centxt::all()));
        // event(new Runtxt(ModelsRuntxt::all()));
        // event(new Jdwlsho(Jadwal::all()));
        // $kajian = DB::table('kajian')
        // ->leftJoin('ustadz', 'kajian.ulama', '=', 'ustadz.id')
        // ->select('kajian.*', 'ustadz.name AS ulamaName')
        // ->get()
        // ->map(function ($item) {
        //     // Gunakan Carbon untuk memformat tanggal
        //     $formattedDate = Carbon::parse($item->tgl_pelaksanaan)->translatedFormat('d M Y');

        //     // Ganti nama bulan ke Bahasa Indonesia
        //     $item->tgl_pelaksanaan = str_replace(
        //         ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        //         ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        //         $formattedDate
        //     );
        //     return $item;
        // }); 
        // event(new Jdwlkaj($kajian));
        // $muharramStart = Carbon::create(2024, 7, 7);

        // // Nama bulan Islam
        // $islamicMonths = [
        //     'Muharram',
        //     'Safar',
        //     'Rabiul Awwal',
        //     'Rabiul Akhir',
        //     'Jumadil Awwal',
        //     'Jumadil Akhir',
        //     'Rajab',
        //     'Sya\'ban',
        //     'Ramadhan',
        //     'Syawal',
        //     'Dzulqaidah',
        //     'Dzulhijjah'
        // ];

        // // Panjang bulan Hijriah dalam satu tahun
        // $islamicMonthLengths = [29, 30, 30, 30, 29, 30, 30, 29, 29, 30, 29, 29];

        // // Tanggal sekarang
        // Carbon::setLocale('id');
        // $currentDate = Carbon::now();

        // // Hitung selisih hari dari 1 Muharram
        // $daysDifference = $muharramStart->diffInDays($currentDate, false);

        // // Jika sebelum 1 Muharram
        // if ($daysDifference < 0) {
        //     return "Tanggal sekarang sebelum 1 Muharram 1446 H.";
        // }

        // // Mulai hitung bulan dan tanggal Hijriah
        // $currentYear = 1446; // Tahun Hijriah awal
        // $currentMonthIndex = 0; // Indeks bulan pertama (Muharram)
        // $remainingDays = $daysDifference;

        // // Iterasi untuk menghitung bulan Hijriah berdasarkan panjang bulan
        // while ($remainingDays >= $islamicMonthLengths[$currentMonthIndex]) {
        //     $remainingDays -= $islamicMonthLengths[$currentMonthIndex];
        //     $currentMonthIndex++;

        //     // Jika melewati bulan Dzulhijjah, reset ke Muharram dan tambah tahun
        //     if ($currentMonthIndex >= 12) {
        //         $currentMonthIndex = 0;
        //         $currentYear++;
        //     }
        // }

        // // Tanggal dalam bulan Hijriah saat ini
        // $currentHijriDate = $remainingDays + 1;
        // $currentMonth = $islamicMonths[$currentMonthIndex];

        // // Tampilkan hasil
        // $data = [
        //     'tglHijriah' => $currentHijriDate . ' ' . $currentMonth . ' ' . $currentYear . ' H',
        //     'tglBiasa' => $currentDate->isoFormat('dddd, D MMMM YYYY')
        // ];
        // event(new TanggalIslam($data));
        if (Storage::exists('waktu_terakhir.json')) {
            $data = json_decode(Storage::get('waktu_terakhir.json'), true);
            $storedTimestamp = strtotime($data['dateTime']); // Konversi ke timestamp
            $currentTimestamp = time(); // Waktu saat ini dari server
            $timeDiff = $currentTimestamp - $storedTimestamp; // Selisih detik

            // Hitung waktu sekarang berdasarkan waktu tersimpan + selisih waktu
            $updatedDateTime = $storedTimestamp + $timeDiff;
            $finalTime = date('Y-m-d H:i:s', $updatedDateTime);

            return view('fathtronik.index', compact('finalTime')); // Kirim ke Blade
        }

        return view('fathtronik.index')->with('finalTime', null);
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
        //
    }
}
