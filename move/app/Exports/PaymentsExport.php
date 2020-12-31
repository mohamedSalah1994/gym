<?php

namespace App\Exports;

use App\payments;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\Exportable;
class PaymentsExport implements  FromCollection , WithHeadings , WithMapping , ShouldAutoSize , WithColumnFormatting , WithEvents
{
    use Exportable, RegistersEventListeners;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if(Carbon::parse(session()->get('start'))->equalTo(Carbon::parse(session()->get('end')))){
             return payments::whereDate('created_at','=',Carbon::parse(session()->get('start'))->toDateTimeString())->where('status','PAID')->get();
        }
        return payments::whereDate('created_at','>=',Carbon::parse(session()->get('start'))->toDateTimeString())->whereDate('created_at','<=',Carbon::parse(session()->get('end'))->toDateTimeString())->where('status','PAID')->get();
    }
    private  $i = 1;
         public function map($payment): array
    {
        return [
             $this->i++ , 
             $payment->userObj->name , 
             $payment->userObj->identity , 
             $payment->amount , 
             $payment->paid , 
             Carbon::parse($payment->created_at)->format('Y-m-d') , 
             ($payment->adminOb) ? $payment->adminOb->name : 'tap' , 
          
        ];
    }
      public function headings(): array
    {
        return [
            '#',
            'User Name',
            'Identity',
            'Amount',
            'Payment Way',
            'Payment Date',
            'Officer Name',
        
        ];
    }
      public function columnFormats(): array
    {
        return [
            'C' => '0',
            'D' => '0.00',
        ];
    }
    public static function afterSheet(AfterSheet $event){
        if(Carbon::parse(session()->get('start'))->equalTo(Carbon::parse(session()->get('end')))){
             $total = payments::whereDate('created_at','=',Carbon::parse(session()->get('start'))->toDateTimeString())->where('status','PAID')->sum('amount');
        }
        else{
             $total = payments::whereDate('created_at','>=',Carbon::parse(session()->get('start'))->toDateTimeString())->whereDate('created_at','<=',Carbon::parse(session()->get('end'))->toDateTimeString())->where('status','PAID')->sum('amount');
        }
       
        $event->sheet->appendRows(array(
            array(),
            array('', '' ,'Total',number_format($total) . ' KWD'),
        ), $event);
    }
}
