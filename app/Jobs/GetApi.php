<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\ApiLogService;

class GetApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $endtime;
    protected $apiLogService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime, $endtime)
    {
        $this->starttime = $starttime;
        $this->endtime = $endtime;
        $this->apiLogService = new ApiLogService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiLogData = $this->apiLogService->getApiLog($this->starttime, $this->endtime, $from = 0);

        if (isset($apiLogData['error'])) {
            print_r($apiLogData['msg']);
            return;
        } else {
            $checkData = $this->apiLogService->checkApiLog($apiLogData);
        }

        if (isset($checkData['error'])) {
            print_r($checkData['msg']);
            return;
        } else {
            if ($checkData['insertData']) {
                $this->apiLogService->insertApiLog($checkData['insertData']);
            }

            if ($checkData['updateData']) {
                $this->apiLogService->updateApiLog($checkData['updateData']);
            }
        }
    }
}
