<?php

namespace App\Exports;

use App\Models\Fuel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Illuminate\Support\Facades\DB;

class FuelYearlyExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    private $year;

    public function __construct(string $year)
    {
        $this->year = $year;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Bulan',
            'Total Penggunaan',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $first = Carbon::createFromDate($this->year, 1, 1)->startOfDay();
        $last = Carbon::createFromDate($this->year, 12, 1)->lastOfMonth()->endOfDay();

        $fuels = Fuel::select(DB::raw("CONCAT(MONTHNAME(check_date), ' ', YEAR(check_date)) AS bulan, SUM(`usage`) * 6 AS total_usage"))
            ->whereBetween('check_date', [$first,  $last])
            ->groupBy('bulan')
            ->get();
        return $fuels->values();
    }
}
