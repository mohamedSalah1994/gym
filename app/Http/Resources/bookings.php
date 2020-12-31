<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class bookings extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
        'data' => $this->getCollection(),
        'meta' => [
            'total' => $this->total(),
            'perpage' => $this->perPage(),
            'page' => $this->currentPage(),
         
            
        ]
    ];
    }
}
