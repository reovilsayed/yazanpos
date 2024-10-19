<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeShiftSingleExport;
use App\Models\EmployeeShift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportShiftSingle(Request $request)
    {
        $shifts = EmployeeShift::with('user');
        if ($request->from) {
            $shifts = $shifts->whereDate('clock_in', '>=', $request->from);
        }
        if ($request->to) {
            $shifts = $shifts->whereDate('clock_in', '<=', $request->to);
        }
        $totalHours = 0;
        $data = $shifts->get()
            ->map(function ($shift) use (&$totalHours) {
                $elapsedHours = Carbon::parse($shift->clock_in)->diffInHours(Carbon::parse($shift->clock_out));
                $totalHours += $elapsedHours;
                return [
                    'Employee ID' => $shift->user->id,
                    'Employee Name' => $shift->user->name,
                    'Clock In Date' => Carbon::parse($shift->clock_in)->format('Y-m-d'),
                    'Clock In Time' => Carbon::parse($shift->clock_in)->format('H:i:s'),
                    'Clock Out Date' => Carbon::parse($shift->clock_out)->format('Y-m-d'),
                    'Clock Out Time' => Carbon::parse($shift->clock_out)->format('H:i:s'),
                    'Elapsed Hours' => $elapsedHours > 0 ? $elapsedHours : '0',
                ];
            });

        $data->push([
            'Employee ID' => '',
            'Employee Name' => 'Total',
            'Clock In Date' => '',
            'Clock In Time' => '',
            'Clock Out Date' => '',
            'Clock Out Time' => '',
            'Elapsed Hours' => $totalHours . ' ' . 'Hour',
        ]);

        $firstUserName = $data->first()['Employee Name'];
        return Excel::download(new EmployeeShiftSingleExport($data), $firstUserName . '_shift.xlsx');
    }
}
