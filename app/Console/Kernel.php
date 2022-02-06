<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:evolutionFilleul')
                 ->daily();
        $schedule->command('command:updatetva')
                 ->daily();
        $schedule->command('command:updatejeton')
                 ->daily();
                 
        $schedule->command('command:cloturercompromis')
        ->daily();
                 
        $schedule->command('command:findroitsuite')
                 ->daily();
                 
        $schedule->command('command:changementtva')
                 ->daily();
                 
         $schedule->command('command:mandataireazero')
                 ->daily();
                 
        $schedule->command('command:evolutionpackstarter')
                 ->daily();
  
        $schedule->command('command:listerfactpub')
                 ->monthlyOn(28, '01:00');	;

        $schedule->command('command:documentexpire')
                 ->monthlyOn(28, '02:00');	;
                 
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
