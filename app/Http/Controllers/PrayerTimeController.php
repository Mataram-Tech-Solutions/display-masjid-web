<?php

namespace App\Http\Controllers;

use App\Models\Astronomis;
use App\Models\Jadwal;
use App\Services\PrayerTimeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrayerTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PrayerTimeService::dataPerhitungan('2025-01-01');
        
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
