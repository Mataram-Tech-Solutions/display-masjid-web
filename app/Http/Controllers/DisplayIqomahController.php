<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayIqomahController extends Controller
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

    public function displayIqomah(Request $request)
    {
        $menitIqomah = $request->query('menitIqomah');
        $buzzerIqomah =  $request->query('buzzer');

        // Validasi data
        if (!$menitIqomah || !$buzzerIqomah) {
            abort(400, 'Invalid input');
        }
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $menitIqomah
        // ], 200);  
        return view('iqomah.index', [
            'iqomah' => $menitIqomah,
            'buzzer' => $buzzerIqomah,
        ]);
    }
}
