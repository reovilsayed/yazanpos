<?php

namespace App\Console\Commands;

use App\Mail\DueClearReminder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDueReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:due-reminder-emails';
    protected $description = 'Send reminder emails to customers with overdue payments';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customers = User::where('role_id', 2)->where(function ($query) {
            $query->whereNull('last_reminder_date')
                ->orWhere('last_reminder_date', '<=', now()->subDays(30));
        })
            ->whereHas('orders', function ($query) {
                $query->where('due', '>', 0);
            })
            ->whereNotNull('email')
            ->take(10)
            ->get();

        foreach ($customers as $customer) {

            $orders = $customer->orders()->where('due', '>', 0)->get();
            if ($customer->email) {
                Mail::to($customer->email)->bcc('reovilsayed@gmail.com')->send(new DueClearReminder($orders, $customer));
                $customer->update(['last_reminder_date' => now()]);
            }
        }

        $this->info('Reminder emails sent successfully!');
    }
}
