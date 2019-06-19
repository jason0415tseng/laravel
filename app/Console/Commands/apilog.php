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
        $starttime = $this->option('starttime');
        $endtime = $this->option('endtime');

        //時間判斷
        if (empty($starttime)) {
            $nowTime = date('Y-m-d H:i', time()) . ':00';
            $starttime = date('Y-m-d H:i:s', strtotime("$nowTime -5 minute"));
            $starttime = str_replace(' ', 'T', $starttime);
            $endtime = date('Y-m-d H:i', strtotime($nowTime)) . ':59';
            $endtime = str_replace(' ', 'T', $endtime);
        }

        if (empty($endtime)) {
            $endtime = date('Y-m-d H:i', strtotime($starttime)) . ':59';
            $endtime = str_replace(' ', 'T', $endtime);
        }

        if ($starttime > $endtime) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('結束時間請勿小於開始時間');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        if ($starttime == $endtime) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('結束時間請勿等於開始時間');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        $job = new GetApi($starttime, $endtime);
        dispatch($job);
    }
}
