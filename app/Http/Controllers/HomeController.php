<?php

namespace App\Http\Controllers;

use App\Exports\FuelExport;
use App\Exports\FuelYearlyExport;
use App\Http\Requests\ExportRequest;
use App\Http\Requests\ExportYearRequest;
use Illuminate\Http\Request;
use App\Models\Fuel;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start = '';
        $end = '';
        $fuels = Fuel::select('check_date', 'name', 'insert', 'usage')
            ->orderBy('check_date', 'asc')->get();


        $last = 0;
        $isFirst = true;
        foreach ($fuels as $fuel) {
            $fuel->usage_liter = $isFirst ? 0 : $fuel->usage * 6;
            $fuel->current = $last + $fuel->insert - $fuel->usage_liter;
            $fuel->last = $last;

            $last = $last + $fuel->insert - $fuel->usage_liter;
            $isFirst = false;
        }

        if ($request->get('month')) {
            $month = $request->get('month');
            $carbonDate = Carbon::createFromFormat('Y-m', $month);

            $month = $carbonDate->format('m');
            $year = $carbonDate->format('Y');

            $start = Carbon::createFromDate($year, $month, 1)->firstOfMonth()->toDateString();
            $end = Carbon::createFromDate($year, $month, 1)->lastOfMonth()->toDateString();

            $fuels = $fuels->filter(function ($value) use ($start, $end) {
                return $value->check_date >= $start && $value->check_date <= $end;
            });

        }

        return view('pages.home', [
            'fuels' => $fuels->reverse()->values()
        ]);
    }

    public function export(ExportRequest $request)
    {
        // curent timestamps
        $file_name = 'fuel_' . $request->month . '.xlsx';

        return Excel::download(new FuelExport($request->month), $file_name);
    }

    public function exportYear(ExportYearRequest $request)
    {
        // curent timestamps
        $file_name = 'fuel_' . $request->year . '.xlsx';

        return Excel::download(new FuelYearlyExport($request->year), $file_name);
    }
}
