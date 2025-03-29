<?php

namespace App\Http\Controllers;

use App\Events\Jdwlsho;
use App\Events\TanggalReal;
use App\Events\WaktuReal;
use App\Services\PrayerTimeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SetwaktuController extends Controller
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
        $tglReq = $request->tanggal;
        $jamReq = $request->jam_hour;
        $menitReq = $request->menit_minute;
        try {
        $datetime = Carbon::createFromFormat('Y-m-d H:i', 
            "{$tglReq} {$jamReq}:{$menitReq}"
        )->format('Y-m-d H:i:s');

        // Simpan ke Cache
        Cache::put('post_datetime', $datetime, now()->addMinutes(10));

        // Kirim data ke ESP8266
        try {
            $response = Http::post('http://192.168.37.111/set-datetime', [
                'datetime' => $datetime
            ]);
    
            // Cek apakah ESP8266 menerima data dengan sukses
            if (!$response->successful()) {
                session()->flash('error', 'ESP8266 gagal menerima data.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghubungi ESP8266: ' . $e->getMessage());
        }
        $cache = Cache::get('post_datetime');
        $date = Carbon::parse($cache)->format('Y-m-d');
        $time = Carbon::parse($cache)->format('H:i:s');
        event(new Jdwlsho(PrayerTimeService::dataPerhitungan($date)));
        event(new WaktuReal($time));
        event(new TanggalReal($date));
        return redirect()->route('setwaktu')->with('success', 'Data berhasil diperbarui!');
            } catch (\Exception $e) {
                // Redirect ke edit jika gagal dengan pesan error
                return redirect()->route('setwaktu-edit')->with('error', 'Terjadi kesalahan dari server!');
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
        //
    }
}
