<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\EmployeeShift;
use Carbon\Carbon;

class CheckInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:inactive-user-shift';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close inactive user shift';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inactiveTime = Carbon::now()->subHours(1);

        $inactiveTime = now()->subHour();
        $inactiveShifts = EmployeeShift::where('status', 1)
            ->whereHas('user', function ($query) use ($inactiveTime) {
                $query->where('last_activity', '<', $inactiveTime);
            })
            ->get();
        
        foreach ($inactiveShifts as $shift) {
            $shift->update([
                'clock_out' => now(),
                'status' => 2 
            ]);
        }
    }
}
