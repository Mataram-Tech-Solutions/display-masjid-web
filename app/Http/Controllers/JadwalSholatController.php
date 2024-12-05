<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Jadwal;
use App\Models\Ustadz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalSholatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Jadwal::with(['jdwlustadz', 'jdwlkhatib', 'audioadzan', 'audiomur'])->get();            
        return view('jadwalSholat.index', [
            'list' => $list,
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
        $datalama = Jadwal::with(['jdwlustadz', 'jdwlkhatib', 'audioadzan', 'audiomur'])->find($id);
        $listaudio = Audio::all();
        $isChecked = $datalama->audstat;
        if($isChecked == 0){
            $isChecked = false;
        } else {
            $isChecked = true;
        }
        $isCheckedmur = $datalama->audmurstat;
        if($isCheckedmur == 0){
            $isCheckedmur = false;
        } else {
            $isCheckedmur = true;
        }
        $ulama = Ustadz::where('ustd', '!=', 'ustadzah')->get();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $datalama
        // ], 200);
        return view('jadwalSholat.edit', [
            'sebelumnya' => $datalama,
            'audio' => $listaudio,
            'adzanstat' => $isChecked,
            'murstat' => $isCheckedmur,
            'ustad' => $ulama,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sholat = $request->input('shalat');
        $adzanjam = $request->input('adzan_hour');
        $adzanmenit = $request->input('adzan_minute');
        $iqomahjam = $request->input('iqomah_hour');
        $iqomahmenit = $request->input('iqomah_minute');
        $buzzer = $request->input('buzzer');
        $audioadzan = $request->input('audioadzan');
        $audiomur = $request->input('audiomur');
        if ($request->input('adzan_automatis') == "on") {
            $adzanauto = 1;
        } else {
            $adzanauto = 0;
        }
        if ($request->input('murrothal_automatis') == "on") {
            $murrothalauto = 1;
        } else {
            $murrothalauto = 0;
        }
        $imam = $request->input('imam');
        $khatib = $request->input('khatib');
        try {
        $jadwal = Jadwal::findOrFail($id);

        // Update data
        $jadwal->shalat = $sholat;
        $jadwal->waktu_adzan = sprintf('%02d:%02d:00', $adzanjam, $adzanmenit);
        $jadwal->waktu_iqomah = sprintf('%02d:%02d:00', $iqomahjam, $iqomahmenit);
        $jadwal->buzzeriqomah = $buzzer;
        $jadwal->audio = $audioadzan;
        $jadwal->audmur = $audiomur;
        $jadwal->audstat = $adzanauto;
        $jadwal->audmurstat = $murrothalauto;
        $jadwal->imam = $imam;
        $jadwal->khatib = $khatib;
        $jadwal->updated_by = Auth::user()->id;

        // Simpan ke database
        $jadwal->save();
        return redirect()->route('jadwalsholat.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            // Redirect ke edit jika gagal dengan pesan error
            return redirect()->route('jadwalsholat.edit', $id)->with('error', 'Terjadi kesalahan dari server!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
