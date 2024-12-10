<?php

namespace App\Http\Controllers;

use App\Events\WaktuReal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaktuRealController extends Controller
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
        event(new WaktuReal($request->time));
        return response()->json([
            'status' => 'success',
            'data' => [
                [
                    'time' => $request->time // Kembalikan dalam format H:i:s
                ]
            ]
        ], 200);
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
