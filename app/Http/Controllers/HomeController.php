<?php

namespace App\Http\Controllers;

use App\Exports\FuelExport;
use App\Http\Requests\ExportRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Fuel\CreateRequest;
use App\Models\Fuel;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fuels = Fuel::orderBy('check_date', 'asc')->get();

        $last = 0;
        $isFirst = true;
        foreach ($fuels as $fuel) {
            $fuel->usage_liter = $isFirst ? 0 : 80 + $fuel->usage * 40;
            $fuel->current = $last + $fuel->insert - $fuel->usage_liter;
            $fuel->last = $last;

            $last = $last + $fuel->insert - $fuel->usage_liter;
            $isFirst = false;
        }

        return view('pages.home', [
            'fuels' => $fuels->reverse()->values()
        ]);
    }

    public function export(ExportRequest $request)
    {
        // curent timestamps
        $current = date('Y-m-d');
        $file_name = 'fuel_' . $current . '.xlsx';

        return Excel::download(new FuelExport($request->month), $file_name);
    }
}
