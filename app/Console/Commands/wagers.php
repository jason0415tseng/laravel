<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GetWagers;

class wagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wagers:get {--S|starttime= : format: 2019-05-01T00:00:00}  {--E|endtime= : format: 2019-05-01T23:59:59}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Apilog to Wagers';

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
            $nowTime = new \DateTime();
            $nowTime->format('Y-m-d H:i') . ':00';
            $starttime = $nowTime->sub(new \DateInterval('PT5M'));
            $starttime = $starttime->format('Y-m-d H:i') . ':00';
            $starttime = str_replace(' ', 'T', $starttime);
            $endtime = new \DateTime($starttime);
            $endtime = $endtime->format('Y-m-d H:i') . ':59';
            $endtime = str_replace(' ', 'T', $endtime);
        }

        if (empty($endtime)) {
            $endtime = new \DateTime($starttime);
            $endtime = $endtime->format('Y-m-d H:i') . ':59';
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

        if ((strtotime($endtime) - strtotime($starttime)) > 60) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('可輸入時間範圍只有一分鐘');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        $job = new GetWagers($starttime, $endtime);
        dispatch($job);
    }
}
