<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WaktuCarbonContoller extends Controller
{
    public function store(Request $request)
    {
        // Validasi input dari ESP32
        $request->validate([
            'date' => 'required|date',
            'time' => 'required'
        ]);

        // Konversi waktu input ESP32 ke Unix Timestamp
        $dateTime = strtotime($request->date . ' ' . $request->time);

        // Simpan waktu input ESP32 + waktu server menerima data
        $savedTime = [
            'dateTime' => $dateTime, // Waktu awal dalam Unix Timestamp
            'stored_at' => time() // Waktu saat ini dalam Unix Timestamp (tanpa RTC)
        ];
        Storage::put('waktu_terakhir.json', json_encode($savedTime));

        return response()->json([
            'message' => 'Waktu berhasil disimpan',
            'dateTime' => date('Y-m-d H:i:s', $dateTime)
        ]);
    }

    public function getTime()
    {
        // Cek apakah ada data tersimpan
        if (Storage::exists('waktu_terakhir.json')) {
            $data = json_decode(Storage::get('waktu_terakhir.json'), true);
            $storedDateTime = $data['dateTime']; // Waktu awal dalam Unix Timestamp
            $storedAt = $data['stored_at']; // Waktu saat penyimpanan

            // Hitung selisih waktu berdasarkan Unix Timestamp
            $elapsedSeconds = time() - $storedAt;

            // Hitung waktu yang telah berjalan dan update waktu
            $updatedDateTime = $storedDateTime + $elapsedSeconds;

            return response()->json([
                'original_time' => date('Y-m-d H:i:s', $storedDateTime),
                'updated_time' => date('Y-m-d H:i:s', $updatedDateTime),
                'elapsed_seconds' => $elapsedSeconds
            ]);
        }

        return response()->json(['message' => 'Belum ada data tersimpan'], 404);
    }

    public function showTime()
    {
        if (Storage::exists('waktu_terakhir.json')) {
            $data = json_decode(Storage::get('waktu_terakhir.json'), true);
            $storedTimestamp = strtotime($data['dateTime']); // Konversi ke timestamp
            $currentTimestamp = time(); // Waktu saat ini dari server
            $timeDiff = $currentTimestamp - $storedTimestamp; // Selisih detik

            // Hitung waktu sekarang berdasarkan waktu tersimpan + selisih waktu
            $updatedDateTime = $storedTimestamp + $timeDiff;
            $finalTime = date('Y-m-d H:i:s', $updatedDateTime);

            return view('fathtronik', compact('finalTime')); // Kirim ke Blade
        }

        return view('fathtronik')->with('finalTime', null);
    }

}
