<?php

namespace App\Exports;

use App\Models\Fuel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FuelExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Nama Pengawas',
            'Sisa Bulan Lalu',
            'Sisa Sekarang',
            'Penggunaan Bulan Lalu (Liter)',
            'Penggunaan Bulan Lalu (Jam)',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Fuel::select('name', 'last', 'current', 'usage', 'usage_hour')->orderBy('check_date', 'desc')->get();
    }
}
