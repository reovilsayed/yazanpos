<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class InventoryExport implements FromCollection
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {

        $headings = collect([[
            'ID',
            'Name',
            // 'Alternate Name',
            'Price',
            // 'Price Type',
            'Price Unit',
            'Tax Rates',
            // 'Cost',
            // 'Product Code',
            'SKU',
            // 'Modifier Groups',
            'Quantity',
            // 'Printer Labels',
            // 'Hidden',
            // 'Non-revenue item',
            // 'Discountable',
            // 'Max Discount Allowed',
            // 'Tags',
        ]]);

        return $headings->merge($this->data);
    }
}
