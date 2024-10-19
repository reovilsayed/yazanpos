<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeShiftSingleExport implements FromCollection
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

        $headings = collect([['Employee ID', 'Employee Name','Clock In Date', 'Clock In Time', 'Clock Out Date', 'Clock Out Time', 'Elapsed Hours']]);

        return $headings->merge($this->data);
    }
}
