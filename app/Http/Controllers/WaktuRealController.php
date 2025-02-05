<?php

namespace App\Http\Controllers;

use App\Events\AdzAut;
use App\Events\Hadist;
use App\Events\Jdwlkaj;
use App\Events\Jdwlsho;
use App\Events\PrimarydisUpdated;
use App\Events\ProfileMasjid;
use App\Events\Runtxt;
use App\Events\TanggalIslam;
use App\Events\WaktuReal;
use App\Models\Centxt;
use App\Models\Jadwal;
use App\Models\Kajian;
use App\Models\Masjid;
use App\Models\Primarydis;
use App\Models\Runtxt as ModelsRuntxt;
use App\Services\PrayerTimeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WaktuRealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $jadwal = DB::table('jadwal')
        ->leftJoin('audio', 'jadwal.audio', '=', 'audio.id')
        ->leftJoin('ustadz', 'jadwal.imam', '=', 'ustadz.id')
        ->select(
            'jadwal.*', // Semua kolom dari tabel jadwal
            DB::raw("CONCAT(audio.unique, '_', audio.name) AS unique_name"),
            'ustadz.name AS imam_name' // Tambahkan kolom dengan alias dari tabel ustadz jika diperlukan
        )->get();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $jadwal
        // ], 200);  
        event(new PrimarydisUpdated(Primarydis::all()));
        event(new Hadist(Centxt::all()));
        event(new ProfileMasjid(Masjid::all()));
        event(new Hadist(Centxt::all()));
        event(new Runtxt(ModelsRuntxt::all()));
        $kajian = DB::table('kajian')
        ->leftJoin('ustadz', 'kajian.ulama', '=', 'ustadz.id')
        ->select('kajian.*', 'ustadz.name AS ulamaName')
        ->get()
        ->map(function ($item) {
            // Gunakan Carbon untuk memformat tanggal
            $formattedDate = Carbon::parse($item->tgl_pelaksanaan)->translatedFormat('d M Y');

            // Ganti nama bulan ke Bahasa Indonesia
            $item->tgl_pelaksanaan = str_replace(
                ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                $formattedDate
            );
            return $item;
        }); 
        event(new Jdwlkaj($kajian));
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
        $islamicMonthLengths = [29, 30, 30, 30, 29, 30, 30, 29, 29, 30, 29, 29,
        30, 29, 30, 30, 30, 29, 30, 29, 30, 29, 30, 29,
        29, 30, 29, 30, 30, 29, 30, 30, 29, 30, 29, 30,
        29, 29, 30, 29, 30, 29, 30, 30, 29, 30, 30, 29,
        30, 29, 30, 29, 29, 30, 29, 30, 29, 30, 30, 29];

        // Tanggal sekarang
        Carbon::setLocale('id');
        $tanggalDisplay = Carbon::parse($request->date);
        $currentDate = $tanggalDisplay;

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

        $lengthOfMonthArray = count($islamicMonthLengths);

       // Iterasi untuk menghitung bulan Hijriah berdasarkan panjang bulan
        while ($remainingDays >= $islamicMonthLengths[$currentMonthIndex]) {
            $remainingDays -= $islamicMonthLengths[$currentMonthIndex];
            $currentMonthIndex++;

            // Jika melewati bulan Dzulhijjah (bulan ke-12), reset ke Muharram dan tambah tahun
            if ($currentMonthIndex % 12 === 0) {
                $currentYear++;
            }

            // Menghindari indeks array di luar batas
            if ($currentMonthIndex >= count($islamicMonthLengths)) {
                $currentMonthIndex = 0; // Reset jika melebihi panjang array
            }
        }

        // Tanggal dalam bulan Hijriah saat ini
        $currentHijriDate = $remainingDays + 1;
        $currentMonth = $islamicMonths[$currentMonthIndex % 12]; // Menggunakan modulo 12 untuk memastikan bulan Hijriah valid

        // Tampilkan hasil
        $data = [
            'tglHijriah' => $currentHijriDate . ' ' . $currentMonth . ' ' . $currentYear . ' H',
            'tglBiasa' => $currentDate->isoFormat('dddd, D MMMM YYYY')
        ];

        event(new TanggalIslam($data));
        $tes = event(new WaktuReal($request->time));
        Cache::put('server_time', $request->time, now()->addMinutes(10));
        event(new Jdwlsho(PrayerTimeService::dataPerhitungan($request->date)));
        return response()->json([
            'status' => 'success',
            'data' => [
                [
                    'time' => $request->time, // Kembalikan dalam format H:i:s
                    'date' => $request->date,
                    'data' => PrayerTimeService::dataPerhitungan($request->date)
                     // Kembalikan dalam format H:i:s
                ]
            ]
        ], 200);
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
