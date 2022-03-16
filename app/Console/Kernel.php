<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Stringable;
use Carbon\Carbon;

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
        $schedule->call(function () {
            
            $limit = Carbon::now()->addDays(20);

            $inserted_guarantees = DB::table('Guarantees')->select('id as guarantee_id')
            ->where('status', 'مدخلة')
            ->where('merit_date', '<=', $limit)
            ->get()
            ->toArray();

            $ex_guarantees = DB::table('Guarantees')
            ->where('status', 'ممددة من القسم')
            ->orwhere('status', 'ممددة من البنك')
            ->get()
            ->toArray();

            $extended_guarantees = collect($ex_guarantees)->map(function($collection, $key) {
                $book = DB::table('guarantee_books')
                ->where('guarantee_id', '=', $collection->id)
                ->latest()
                ->limit(1)
                ->get();
                
                $limit = Carbon::now()->addDays(20);
                if ($book[0]->new_merit <= $limit) {
                    return (object) ['guarantee_id'=> $collection->id];
                }
            })->toArray();

            $all_guarantees = array_merge($inserted_guarantees, array_filter($extended_guarantees));

            foreach ($all_guarantees as $guarantee) {
                DB::table('owed_guarantees_initial')->insertOrIgnore(['guarantee_id' => $guarantee->guarantee_id]);
            }
        })
        ->name('guarantees_task')
        ->withoutOverlapping()
        ->everyMinute()
        ->onSuccess(function (Stringable $output) {
            echo ($output . " sucess");
        })
        ->onFailure(function (Stringable $output) {
            echo ($output. " failure");
        });
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
