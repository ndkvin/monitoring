<?php

namespace App\Exports;

use App\Models\Fuel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FuelExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    private $month;

    public function __construct(string $month)
    {
        $this->month = $month;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Tanggal Cek',
            'Penggunaan Mingu Lalu (Jam)',
            'Penggunaan Minggu Lalu (Liter)',
            'Sisa Sekarang',
            'Sisa Minggu Lalu',
            'Cek',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $carbonDate = Carbon::createFromFormat('Y-m', $this->month);

        $month = $carbonDate->format('m');
        $year = $carbonDate->format('Y');

        $start = Carbon::createFromDate($year, $month, 1)->firstOfMonth()->toDateString();
        $end = Carbon::createFromDate($year, $month, 1)->lastOfMonth()->toDateString();

        $fuels = Fuel::select('check_date', 'name', 'insert', 'usage')
                ->orderBy('check_date', 'asc')->get();

        $last = 0;
        $isFirst = true;
        foreach ($fuels as $fuel) {
            $fuel->usage_liter = $isFirst ? 0 : $fuel->usage * 6;
            $fuel->current = $last + $fuel->insert - $fuel->usage_liter;
            $fuel->last = $last;
            $last = $last + $fuel->insert - $fuel->usage_liter;
            unset($fuel->insert);
            unset($fuel->name);
            $isFirst = false;
        }

        $filteredFuels = $fuels->filter(function ($value) use ($start, $end) {
            return $value->check_date >= $start && $value->check_date <= $end;
        });
    
        $totalUsageLiter = $filteredFuels->sum('usage_liter');

        $filteredFuels->push((object)[
            '' => 'Total Penggunaan',
            'a' => '',
            'usage_liter' => $totalUsageLiter,
        ]);
    
        return $filteredFuels->values();
    }
}
