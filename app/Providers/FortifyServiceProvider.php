<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Events\PrimarydisUpdated;
use App\Events\TanggalIslam;
use App\Models\Primarydis;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        Event::listen(Login::class, function ($event) {
            // Trigger event setelah login berhasil
            event(new PrimarydisUpdated(Primarydis::all()));
            // Tanggal 1 Muharram 1446 H dalam kalender Masehi
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
        });
    }
}
