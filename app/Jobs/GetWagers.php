<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\WagersService;

class GetWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $endtime;
    protected $WagersService;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($starttime, $endtime)
    {
        $this->starttime = $starttime;
        $this->endtime = $endtime;
        $this->WagersService = new WagersService;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle()
    {

        $apiLogList = $this->WagersService->getApiLogList($this->starttime, $this->endtime);

        if (isset($apiLogList['error'])) {
            print_r($apiLogList['msg']);
            return;
        } else {
            $insertData = $this->WagersService->checkWagers($apiLogList);
        }

        if (isset($insertData['error'])) {
            print_r($insertData['msg']);
            return;
        } else {
            $this->WagersService->insertWagers($insertData);
        }
    }
}
