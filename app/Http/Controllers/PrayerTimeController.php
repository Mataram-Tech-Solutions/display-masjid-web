<?php

namespace App\Http\Controllers;

use App\Models\Astronomis;
use App\Models\Jadwal;
use App\Services\PrayerTimeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedDate = '2025-01-03';
        $date = Carbon::createFromFormat('Y-m-d', $selectedDate);

        // Ambil hari dalam setahun (yday)
        $yday = $date->dayOfYear;
        $dataAstro = Astronomis::with(['waktuWilayah'])->get();

        $firstDataAstro = $dataAstro->first();

        $latitude = $firstDataAstro->latitude;
        $longitude = $firstDataAstro->longitude;
        $ketinggianLaut = $firstDataAstro->ketinggian_laut;
        $sufajarsenja = $firstDataAstro->sudut_fajarsenja;
        $sumalamsenja = $firstDataAstro->sudut_malamsenja;
        $gmt = $firstDataAstro->waktuWilayah->gmt_selisih;
        // Ambil data Jadwal
        $list = Jadwal::with(['jdwlustadz', 'jdwlkhatib', 'audioadzan', 'audiomur'])->get();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $list
        // ], 200);  

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
        $data = $list->map(function ($jadwal) use ($latitude, $longitude, $ketinggianLaut, $sufajarsenja, $sumalamsenja, $gmt, $yday) {
            // Perhitungan waktu adzan untuk setiap salat
            $waktuAdzan = PrayerTimeService::calculatePrayerTime($yday, $ketinggianLaut, $sufajarsenja, $sumalamsenja, $latitude, $longitude, $gmt, $jadwal->shalat_id);
            
            // Menentukan waktu adzan yang sesuai dengan shalat yang diminta
            $waktuAdzanFormatted = [
                "Imsak" => $waktuAdzan['imsak'],
                "Shubuh" => $waktuAdzan['subuh'],
                "Syuruq" => $waktuAdzan['syuruq'],
                "Dzuhur" => $waktuAdzan['dzuhur'],
                "Ashr" => $waktuAdzan['ashar'],
                "Maghrib" => $waktuAdzan['maghrib'],
                "Isya" => $waktuAdzan['isya'],
            ];
        
            // Mengambil waktu adzan sesuai dengan shalat yang diminta (misalnya 'imsak', 'subuh', dll)
            $waktuAdzanRequested = $waktuAdzanFormatted[$jadwal->shalat] ?? null;
        
            return [
                "id" => $jadwal->id,
                "shalat" => $jadwal->shalat, // Nama shalat
                "waktu_adzan" => $waktuAdzanRequested, // Hanya waktu adzan yang diminta (misalnya imsak)
                "waktu_iqomah" => $jadwal->waktu_iqomah ?? null,
                "jeda_iqomah" => $jadwal->jeda_iqomah ?? null,
                "akurasi_adzan" => "0",
                "buzzeriqomah" => $jadwal->buzzeriqomah ?? null,
                "audmur" => $jadwal->audiomur ?? null,
                "audio" => $jadwal->audio ?? null,
                "audstat" => $jadwal->audstat ?? null,
                "audmurstat" => $jadwal->audmurstat ?? null,
                "imam" => $jadwal->imam ?? null,
                "khatib" => $jadwal->khatib ?? null,
                "created_by" => 1,
                "updated_by" => 1,
                "created_at" => $jadwal->created_at ?? null,
                "updated_at" => $jadwal->updated_at ?? null,
                "jdwlustadz" => $jadwal->jdwlustadz ?? null,
                "jdwlkhatib" => $jadwal->jdwlkhatib ?? null,
                "audioadzan" => $jadwal->audioadzan ?? null,
                "audiomur" => $jadwal->audiomur ?? null,
            ];
        });
        
        // Mengembalikan response JSON
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
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
