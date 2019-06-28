<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\ApiLogService;

ini_set('memory_limit', '-1');

class GetApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $from;
    protected $total;
    protected $apiLogService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime)
    {
        $this->starttime = $starttime;
        $this->from = 0;
        $this->total = 1;
        $this->apiLogService = new ApiLogService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        while ($this->from <= $this->total) {
            $apiLogData = $this->apiLogService->getApiLog($this->starttime, $this->from);

            if ($apiLogData) {
                $checkData = $this->apiLogService->checkApiLog($apiLogData);

                $this->apiLogService->insertApiLog($checkData['insertData']);
                $this->apiLogService->updateApiLog($checkData['updateData']);
                $this->total = $apiLogData['hits']['total'];
                $this->from += 10000;
            } else {
                return;
            }
        }
    }
}
