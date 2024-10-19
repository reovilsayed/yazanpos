<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {

        $headings = collect([[
            'Order Date',
            'Order ID',
            'Invoice Number',
            'Order Number',
            // 'Order Type',
            'Order Employee ID',
            'Order Employee Name',
            // 'Order Employee Custom ID',
            'Note',
            'Currency',
            'Tax Amount',
            // 'Tip',
            // 'Service Charge',
            'Discount',
            'Order Total',
            'Payments Total',
            // 'Payment Note',
            // 'Refunds Total',
            // 'Manual Refunds Total',
            // 'Tender',
            // 'Credit Card Auth Code',
            // 'Credit Card Transaction ID',
            // 'Order Payment State'
            ]]);

        return $headings->merge($this->data);
    }
}
