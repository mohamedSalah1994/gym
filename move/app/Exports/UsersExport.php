<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
class UsersExport implements  FromCollection , WithHeadings , WithMapping , ShouldAutoSize , WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
       public function map($user): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
             $user->id , 
             $user->name , 
             $user->identity , 
             $user->countryCode . $user->mobile , 
             $user->email , 
             Carbon::parse($user->created_at)->format('d-m-yy') , 
        ];
    }
     public function headings(): array
    {
        return [
            '#',
            'Name',
            'Identity',
            'Mobile',
            'Email',
            'Registed Date',
        
        ];
    }
     public function columnFormats(): array
    {
        return [
            'D' => '+#',
            'C' => '@',
        ];
    }
}
