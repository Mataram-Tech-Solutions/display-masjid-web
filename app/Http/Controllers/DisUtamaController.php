<?php

namespace App\Http\Controllers;

use App\Events\Hadist;
use App\Events\Jdwlkaj;
use App\Events\Jdwlsho;
use App\Events\PrimarydisUpdated;
use App\Events\ProfileMasjid;
use App\Events\Runtxt;
use App\Events\TanggalIslam;
use App\Events\TanggalReal;
use App\Events\WaktuReal;
use App\Models\Centxt;
use App\Models\Jadwal;
use App\Models\Kajian;
use App\Models\Masjid;
use App\Models\Primarydis;
use App\Models\Runtxt as ModelsRuntxt;
use App\Services\PrayerTimeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DisUtamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finalTime = "2025-02-10 23:40:07";

        return view( 'fathtronik.index', [
            // 'finalTime' => $finalTime
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
        $datetime = Carbon::createFromFormat('Y-m-d H:i', 
            "{$request->tanggal} {$request->jam_hour}:{$request->menit_minute}"
        )->format('Y-m-d H:i:s');

        // Simpan ke Cache
        Cache::put('post_datetime', $datetime, now()->addMinutes(10));

        // Kirim data ke ESP8266
        try {
            $response = Http::post('http://192.168.37.79/set-datetime', [
                'datetime' => $datetime
            ]);
    
            // Cek apakah ESP8266 menerima data dengan sukses
            if (!$response->successful()) {
                session()->flash('error', 'ESP8266 gagal menerima data.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghubungi ESP8266: ' . $e->getMessage());
        }
    

        $date = Carbon::parse($datetime)->format('Y-m-d');
        $time = Carbon::parse($datetime)->format('H:i:s');
        event(new WaktuReal($time));
        event(new TanggalReal($date));

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
        $currentDate = $date;

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
            'tglBiasa' => Carbon::parse($datetime)->isoFormat('dddd, D MMMM YYYY')
        ];

        event(new TanggalIslam($data));
        // Cache::put('server_time', $time, now()->addMinutes(10));
        event(new Jdwlsho(PrayerTimeService::dataPerhitungan($date)));


        return response()->json(['message' => 'Waktu berhasil disimpan', 'datetime' => $datetime]);
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
