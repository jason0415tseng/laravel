<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class checkWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        //時間
        $date = $this->argument('date');
        $starttime = $this->option('starttime');
        $endtime = $this->option('endtime');

        //時間判斷
        if ($date == 0) {
            $starttime = date('Y-m-d ' . $starttime);
            $endtime = date('Y-m-d ' . $endtime);
        } else {
            $date ? $starttime = $date . ' ' . $starttime : $starttime = date('Y-m-d ' . $starttime);
            $date ? $endtime = $date . ' '  . $endtime : $endtime = date('Y-m-d ' . $endtime);
        }

        if ($starttime > $endtime) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('結束時間請勿小於開始時間');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }
    }
}
