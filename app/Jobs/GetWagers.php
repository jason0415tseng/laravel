<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\WagersService;

ini_set('memory_limit', '-1');

class GetWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $WagersService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime)
    {
        $this->starttime = $starttime;
        $this->WagersService = new WagersService;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle()
    {
        $apiLogList = $this->WagersService->getApiLogList($this->starttime);

        if (isset($apiLogList['error'])) {
            print_r($apiLogList['msg']);
            return;
        } else {
            foreach (array_chunk($apiLogList, 2000, true) as $apiList) {
                $insertData = $this->WagersService->checkWagers($apiList);

                if ($insertData) {
                    $this->WagersService->insertWagers($insertData);
                }
            }
        }
    }
}
