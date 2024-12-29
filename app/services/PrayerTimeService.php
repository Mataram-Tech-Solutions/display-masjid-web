<?php
namespace App\Services;

use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;

class PrayerTimeService
{
    public static function sign($x)
    {
        return $x == 0 ? 0 : $x / abs($x);
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
        $W = (180 / (15 * pi())) * acos((sin(atan(1 / ($Sh + tan(abs($B - $D) * pi() / 180)))) - sin($D * pi() / 180) * sin($B * pi() / 180)) / (cos($D * pi() / 180) * cos($B * pi() / 180)));

        // Mengambil data penyesuaian waktu salat dari database
        $getdata = DB::table('set_perwaktu_shalat')->get();

        $_data = [
            'subuh' => $getdata[0]->perwaktushalat_penyesuaian ?? '+0',
            'dzuhur' => $getdata[1]->perwaktushalat_penyesuaian ?? '+0',
            'ashar' => $getdata[2]->perwaktushalat_penyesuaian ?? '+0',
            'maghrib' => $getdata[3]->perwaktushalat_penyesuaian ?? '+0',
            'isya' => $getdata[4]->perwaktushalat_penyesuaian ?? '+0',
            'terbit' => $getdata[6]->perwaktushalat_penyesuaian ?? '+0',
        ];

        $data = [
            'subuh' => self::appTimeAdd(substr(self::decToHours($Z - $Vd), 0, 5) . ":00", $_data['subuh'] . ' minutes'),
            'terbit' => self::appTimeAdd(substr(self::decToHours($Z - $U), 0, 5) . ":00", $_data['terbit'] . ' minutes'),
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
        $hours = floor($decimal);
        $minutes = ($decimal - $hours) * 60;
        return sprintf("%02d:%02d", $hours, $minutes);
    }
}
