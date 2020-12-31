<?php

namespace App\Exports;

use App\subscriptions;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubscriptionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return subscriptions::all();
    }
}
