<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('bot:task-reminder everyday')->dailyAt('10:30');

         $schedule->command('bot:task-reminder every_week')->weeklyOn(1, '10:30');

         $schedule->command('bot:task-reminder every_two_days')->weeklyOn(1, '10:30');
         $schedule->command('bot:task-reminder every_two_days')->weeklyOn(3, '10:30');
         $schedule->command('bot:task-reminder every_two_days')->weeklyOn(5, '10:30');
         $schedule->command('bot:task-reminder every_two_days')->weeklyOn(7, '10:30');

         $schedule->command('bot:task-reminder every_three_days')->weeklyOn(1, '10:30');
         $schedule->command('bot:task-reminder every_three_days')->weeklyOn(4, '10:30');
         $schedule->command('bot:task-reminder every_three_days')->weeklyOn(7, '10:30');

         $schedule->command('bot:task-reminder every_two_week')->twiceMonthly(1, 16, '10:30');

         $schedule->command('bot:task-reminder every_month')->monthlyOn(1, '10:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
