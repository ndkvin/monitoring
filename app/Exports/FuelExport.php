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
            'Anggota',
            'TTD Anggota',
            'Ketua',
            'TTD Ketua',
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

        // Get the first and last day of the month using Carbon
        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $lastDayOfMonth = Carbon::createFromDate($year, $month, 1)->lastOfMonth()->endOfDay();

        $fuels = Fuel::select('check_date', 'name', 'insert', 'usage')
            ->whereBetween('check_date', [$firstDayOfMonth, $lastDayOfMonth])
            ->orderBy('check_date', 'asc')->get();

        $last = 0;
        $isFirst = true;
        foreach ($fuels as $fuel) {
            $name = $fuel->name;
            $fuel->usage_liter = $isFirst ? 0 : 80 + $fuel->usage * 40;
            $fuel->current = $last + $fuel->insert - $fuel->usage_liter;
            $fuel->last = $last;

            $last = $last + $fuel->insert - $fuel->usage_liter;
            $fuel->anggota = $fuel->name;
            $fuel->ttd_anggota = '';
            $fuel->ketua = 'Onni Wijayanto S.Kom';
            $fuel->ttd_ketua = '';
            unset($fuel->insert);
            unset($fuel->name);
            $isFirst = false;
        }

        return $fuels->reverse()->values();
    }
}
