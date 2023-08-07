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
    public function store(CreateRequest $request)
    {
        $request = $request->all();

        Fuel::create([
            'name' => $request['name'],
            'insert' => $request['insert'],
            'usage' => $request['usage'],
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
        $request = $request->all();

        $fuel->update([
            'name' => $request['name'],
            'insert' => $request['insert'],
            'usage' => $request['usage'],
            'check_date' => $request['check_date'],
        ]);

        return redirect()->route('home')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fuel $fuel)
    {
        $fuel->delete();

        return redirect()->route('home')->with('success', 'Data berhasil dihapus');
    }
}
