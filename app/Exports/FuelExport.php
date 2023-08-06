<?php

namespace App\Exports;

use App\Models\Fuel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class FuelExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Tanggal Cek',
            'Nama Pengawas',
            'Penggunaan Mingu Lalu (Jam)',
            'Penggunaan Minggu Lalu (Liter)',
            'Sisa Sekarang',
            'Sisa Minggu Lalu',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fuels = Fuel::select('check_date', 'name', 'insert', 'usage')->orderBy('check_date', 'asc')->get();

        $last = 0;
        $isFirst = true;
        foreach($fuels as $fuel) {
            $fuel->usage_liter = $isFirst ? 0 : 80 + $fuel->usage*40;
            $fuel->current = $last + $fuel->insert - $fuel->usage_liter;
            $fuel->last = $last;

            $last = $last + $fuel->insert - $fuel->usage_liter;
            unset($fuel->insert);
            $isFirst = false;
        }

        return $fuels->reverse()->values();
    }
}
