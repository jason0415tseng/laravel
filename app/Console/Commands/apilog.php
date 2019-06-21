<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GetApi;

class apilog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apilog:get {--S|starttime= : format: 2019-05-01T00:00:00}  {--E|endtime= : format: 2019-05-01T23:59:59}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Apilog';

    protected $start_Time;
    protected $end_Time;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //時間
        $startTime = $this->option('starttime');
        $endTime = $this->option('endtime');

        $start_Time = new \DateTime($startTime);
        $end_Time = new \DateTime($endTime);

        //時間判斷
        if (empty($startTime)) {
            $start_Time = $start_Time->sub(new \DateInterval('PT5M'));
            $start_Time = $start_Time->setTime($start_Time->format('H'), $start_Time->format('i'), 00);
        }

        if (empty($endTime)) {
            $end_Time = clone $start_Time;
            $end_Time = $end_Time->setTime($end_Time->format('H'), $end_Time->format('i'), 59);
        }

        if ($start_Time > $end_Time) {
            $this->info(' === 開始時間 ' . $startTime . ' ===');
            $this->error('結束時間請勿小於開始時間');
            $this->info(' === 結束時間 ' . $endTime . ' ===');
            return;
        }

        if ($start_Time == $end_Time) {
            $this->info(' === 開始時間 ' . $startTime . ' ===');
            $this->error('結束時間請勿等於開始時間');
            $this->info(' === 結束時間 ' . $endTime . ' ===');
            return;
        }

        while ($start_Time <= $end_Time) {
            $job = new GetApi($start_Time);
            dispatch($job);

            $start_Time->add(new \DateInterval('PT1M'));
        }
    }
}
