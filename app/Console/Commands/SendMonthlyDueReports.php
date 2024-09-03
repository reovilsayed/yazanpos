<?php

namespace App\Console\Commands;

use App\Facades\Settings;
use App\Facades\Settings\SettingsFacade;
use App\Mail\MonthlyDueReport;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlyDueReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send-monthly-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly due reports to customers';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $users = User::whereHas('dueorders')->get();

        $pdfContent =  Pdf::loadview('pages.monthlyDueReports', compact('users'));

        $adminMail = SettingsFacade::option('email');
        if ($adminMail) {
            Mail::to($adminMail)->send(new MonthlyDueReport($pdfContent, $users));
        }
        $this->info('Monthly due reports have been sent successfully.');
    }
}
