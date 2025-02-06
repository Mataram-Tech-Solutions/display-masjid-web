<?php
namespace App\Services;

use App\Models\Astronomis;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrayerTimeService
{
    public static function sign($x)
    {
        return $x == 0 ? 0 : $x / abs($x);
    }

    public static function dataPerhitungan($date) {
        $selectedDate = $date;
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
        Carbon::setLocale('id'); // Atur ke bahasa Indonesia
        $namaHari = Carbon::parse($date)->translatedFormat('l');
        // Ambil data Jadwal
        if ($namaHari == "Jumat") {
            $list = Jadwal::with(['audioadzan', 'jdwlustadz', 'audiomur', 'jdwlkhatib'])
            ->whereIn('shalat', ['Imsak', 'Shubuh', 'Syuruq', 'Jumat', 'Ashr', 'Maghrib', 'Isya'])
            ->orderByRaw("FIELD(shalat, 'Imsak', 'Shubuh', 'Syuruq', 'Jumat', 'Ashr', 'Maghrib', 'Isya')")
            ->select('jadwal.*')
            ->get();
        } else {
            $list = Jadwal::with(['audioadzan', 'jdwlustadz', 'audiomur', 'jdwlkhatib'])
            ->whereIn('shalat', ['Imsak', 'Shubuh', 'Syuruq', 'Dzuhur', 'Ashr', 'Maghrib', 'Isya'])
            ->orderByRaw("FIELD(shalat, 'Imsak', 'Shubuh', 'Syuruq', 'Dzuhur', 'Ashr', 'Maghrib', 'Isya')")
            ->select('jadwal.*')
            ->get();
        }
        // Manipulasi data setelah query jika diperlukan
        $list->map(function ($item) {
            $item->unique_name = $item->audioadzan ? $item->audioadzan->unique . '_' . $item->audioadzan->name : null;
            $item->uniquemur_name = $item->audiomur ? $item->audiomur->unique . '_' . $item->audiomur->name : null;
            $item->imam_name = $item->jdwlustadz ? $item->jdwlustadz->name : null;
            $item->khatib_name = $item->jdwlkhatib ? $item->jdwlkhatib->name : null;
            return $item;
        });

        $data = $list->map(function ($jadwal) use ($latitude, $longitude, $ketinggianLaut, $sufajarsenja, $sumalamsenja, $gmt, $yday, $namaHari) {
            // Perhitungan waktu adzan untuk setiap salat
            $waktuAdzan = PrayerTimeService::calculatePrayerTime($yday, $ketinggianLaut, $sufajarsenja, $sumalamsenja, $latitude, $longitude, $gmt, $jadwal->shalat_id);
                      
            if ($namaHari == "Jumat") {
                $waktuAdzanFormatted = [
                    "Imsak" => $waktuAdzan['imsak'],
                    "Shubuh" => $waktuAdzan['subuh'],
                    "Syuruq" => $waktuAdzan['syuruq'],
                    "Jumat" => $waktuAdzan['dzuhur'],
                    "Ashr" => $waktuAdzan['ashar'],
                    "Maghrib" => $waktuAdzan['maghrib'],
                    "Isya" => $waktuAdzan['isya'],
                ];
            } else {
                $waktuAdzanFormatted = [
                    "Imsak" => $waktuAdzan['imsak'],
                    "Shubuh" => $waktuAdzan['subuh'],
                    "Syuruq" => $waktuAdzan['syuruq'],
                    "Dzuhur" => $waktuAdzan['dzuhur'],
                    "Ashr" => $waktuAdzan['ashar'],
                    "Maghrib" => $waktuAdzan['maghrib'],
                    "Isya" => $waktuAdzan['isya'],
                ];
            }
        
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
                "audmur" => $jadwal->uniquemur_name ?? null,
                "audio" => $jadwal->unique_name ?? null,
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
                "murstart" => $jadwal->murstart ?? null,
            ];
        });

        return $data;
    }

    public static function calculatePrayerTime($J, $H, $Gd, $Gn, $B, $L, $TZ, $Sh)
    {
        $D = 0;    // Solar Declination (degrees)
        $T = 0;    // Equation of Time (minutes)
        $R = 0;    // Reference Longitude (degrees)

        $beta = 2 * pi() * $J / 365;
        $D = (180 / pi()) * (0.006918 - (0.399912 * cos($beta)) + (0.070257 * sin($beta)) - (0.006758 * cos(2 * $beta)) + (0.000907 * sin(2 * $beta)) - (0.002697 * cos(3 * $beta)) + (0.001480 * sin(3 * $beta)));
        $T = 229.18 * (0.000075 + (0.001868 * cos($beta)) - (0.032077 * sin($beta)) - (0.014615 * cos(2 * $beta)) - (0.040849 * sin(2 * $beta)));
        $R = 15 * $TZ;
        $G = 18;

        $Z = 12 + (($R - $L) / 15) - ($T / 60);
        $U = (180 / (15 * pi())) * acos((sin((-0.8333 - 0.0347 * self::sign($H) * sqrt(abs($H))) * (pi() / 180)) - sin($D * (pi() / 180)) * sin($B * (pi() / 180))) / (cos($D * (pi() / 180)) * cos($B * (pi() / 180))));
        $Vd = (180 / (15 * pi())) * acos((-sin($Gd * (pi() / 180)) - sin($D * (pi() / 180)) * sin($B * (pi() / 180))) / (cos($D * (pi() / 180)) * cos($B * (pi() / 180))));
        $Vn = (180 / (15 * pi())) * acos((-sin($Gn * (pi() / 180)) - sin($D * (pi() / 180)) * sin($B * (pi() / 180))) / (cos($D * (pi() / 180)) * cos($B * (pi() / 180))));
        $W = (180 / (15 * pi())) * acos((sin(atan(1 / (1 + tan(abs($B - $D) * pi() / 180)))) - sin($D * pi() / 180) * sin($B * pi() / 180)) / (cos($D * pi() / 180) * cos($B * pi() / 180)));

        // Mengambil data penyesuaian waktu salat dari database
        $getdata = Jadwal::get();

        $_data = [
            'imsak' => $getdata[0]->akurasi_adzan ?? '+0',
            'subuh' => $getdata[1]->akurasi_adzan ?? '+0',
            'syuruq' => $getdata[2]->akurasi_adzan ?? '+0',
            'dzuhur' => $getdata[3]->akurasi_adzan ?? '+0',
            'ashar' => $getdata[4]->akurasi_adzan ?? '+0',
            'maghrib' => $getdata[5]->akurasi_adzan ?? '+0',
            'isya' => $getdata[6]->akurasi_adzan ?? '+0',
        ];

        $data = [
            'imsak' => self::appTimeAdd(substr(self::decToHours($Z - $Vd - 0.1667), 0, 5) . ":00", $_data['imsak'] . ' minutes'),
            'subuh' => self::appTimeAdd(substr(self::decToHours($Z - $Vd), 0, 5) . ":00", $_data['subuh'] . ' minutes'),
            'syuruq' => self::appTimeAdd(substr(self::decToHours($Z - $U), 0, 5) . ":00", $_data['syuruq'] . ' minutes'),
            'dzuhur' => self::appTimeAdd(substr(self::decToHours($Z), 0, 5) . ":00", $_data['dzuhur'] . ' minutes'),
            'ashar' => self::appTimeAdd(substr(self::decToHours($Z + $W), 0, 5) . ":00", $_data['ashar'] . ' minutes'),
            'maghrib' => self::appTimeAdd(substr(self::decToHours($Z + $U), 0, 5) . ":00", $_data['maghrib'] . ' minutes'),
            'isya' => self::appTimeAdd(substr(self::decToHours($Z + $Vn), 0, 5) . ":00", $_data['isya'] . ' minutes'),
        ];        

        return $data;
    }

    public static function appTimeAdd($time, $interval, $format = 'H:i:s')
    {
        $datetime = new \DateTime($time);
        $datetime->modify($interval);
        return $datetime->format($format);
    }

    public static function decToHours($decimal)
    {
        $hours = floor($decimal); // Jam
        $totalMinutes = ($decimal - $hours) * 60; // Total menit desimal
        $minutes = floor($totalMinutes); // Menit integer
        $seconds = round(($totalMinutes - $minutes) * 60); // Detik
    
        // Lakukan pembulatan menit jika detik >= 30
        if ($seconds >= 30) {
            $minutes += 1;
            $seconds = 0; // Reset detik ke 0
        }
    
        // Pastikan menit tidak melebihi 59
        if ($minutes === 60) {
            $minutes = 0;
            $hours += 1; // Tambah jam
        }
    
        return sprintf("%02d:%02d", $hours, $minutes);
    }
}
