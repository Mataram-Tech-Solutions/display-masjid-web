<?php

namespace App\Http\Controllers;

use App\Models\Astronomis;
use App\Models\Jadwal;
use App\Services\PrayerTimeService;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Latitude, Longitude, dan Timezone untuk Surakarta
        // $latitude = -7.556;
        // $longitude = 110.831;
        // $timezoneOffset = 7;
        $dataAstro = Astronomis::with(['waktuWilayah'])->get();

        $firstDataAstro = $dataAstro->first();

        $latitude = $firstDataAstro->latitude;
        $longitude = $firstDataAstro->longitude;
        $ketinggianLaut = $firstDataAstro->ketinggian_laut;
        $sufajarsenja = $firstDataAstro->sudut_fajarsenja;
        $sumalamsenja = $firstDataAstro->sudut_malamsenja;
        $gmt = $firstDataAstro->gmt;

        // Ambil data Jadwal
        $list = Jadwal::with(['jdwlustadz', 'jdwlkhatib', 'audioadzan', 'audiomur'])->get();

        // Waktu salat berdasarkan jadwal (1: Subuh, 3: Dzuhur, 4: Ashar, dll.)
        $jadwalSalat = [
            7 => "imsak",
            1 => "subuh",
            2 => "syuruq",
            3 => "dzuhur",
            4 => "ashar",
            5 => "maghrib",
            6 => "isya",
        ];
        // $jadwalSalat = ['imsak', 'subuh', 'terbit', 'dzuhur', 'ashar', 'maghrib', 'isya'];
        // foreach ($jadwalSalat as $key => $name) {
        //     $waktuAdzan = PrayerTimeService::calculatePrayerTime(
        //         $name, 
        //         $latitude, 
        //         $longitude, 
        //         $ketinggianLaut, 
        //         $sufajarsenja, 
        //         $sumalamsenja, 
        //         $gmt
        //     );
        //     // Gunakan hasil $waktuAdzan untuk API
        // }


        // Format hasil API
        $data = $list->flatMap(function ($jadwal) use ($latitude, $longitude, $ketinggianLaut, $sufajarsenja, $sumalamsenja, $gmt, $jadwalSalat) {
            return collect($jadwalSalat)->map(function ($name, $key) use ($jadwal, $latitude, $longitude, $ketinggianLaut, $sufajarsenja, $sumalamsenja, $gmt) {
                return [
                    "id" => $jadwal->id,
                    "name" => $name,
                    "waktu_adzan" => PrayerTimeService::calculatePrayerTime(getdate()['yday'], $ketinggianLaut, $sufajarsenja, $sumalamsenja, $latitude, $longitude, $gmt, 1),
                    "jdwlustadz" => $jadwal->jdwlustadz, 
                    "jdwlkhatib" => $jadwal->jdwlkhatib,
                    "audioadzan" => $jadwal->audioadzan,
                    "audiomur" => $jadwal->audiomur,
                ];
            });
        });

        return response()->json($data->values());
    }

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $prayerTimes
        // ], 200);  
    

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
