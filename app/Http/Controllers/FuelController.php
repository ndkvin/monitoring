<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Fuel\CreateRequest;
use App\Models\Fuel;
use App\Exports\FuelExport;
use Maatwebsite\Excel\Facades\Excel;

class FuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // curent timestamps
        $current = date('Y-m-d');
        $file_name = 'fuel_' . $current . '.xlsx';
        
        return Excel::download(new FuelExport, $file_name);
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
    public function store(CreateRequest $request)
    {
        $last = Fuel::orderBy('check_date', 'desc')->first();

        $last_fuel = $last ? $last->current : 0;

        $request = $request->all();

        $fuel = Fuel::create([
            'name' => $request['name'],
            'usage_hour' => $request['usage_hour'],
            'usage' => $last_fuel == 0 ? 0  : $last_fuel - $request['last'],
            'last' => $request['last'],
            'current' =>  $request['last']+$request['insert'],
            'check_date' => $request['check_date'],
        ]);

        return redirect()->route('home')->with('success', 'Daat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fuel $fuel)
    {
        return $fuel;
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
    public function update(CreateRequest $request, Fuel $fuel)
    {
        $last = Fuel::orderBy('check_date', 'desc')->first();

        $last_fuel = $last ? $last->current : 0;

        $request = $request->all();

        $fuel->update([
            'name' => $request['name'],
            'usage_hour' => $request['usage_hour'],
            'usage' => $last_fuel == 0 ? 0  : $last_fuel - $request['last'],
            'last' => $request['last'],
            'current' =>  $request['last']+$request['insert'],
            'check_date' => $request['check_date'],
        ]);

        return redirect()->route('home')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
