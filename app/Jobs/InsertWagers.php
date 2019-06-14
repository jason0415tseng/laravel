<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\ApiLogService;

class InsertWagers implements ShouldQueue
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
        $params = [
            'start' => $this->starttime,
            'end' => $this->endtime,
            'from' => '0',
        ];

        $this->apiLogService->getApiLog($params);
    }
}
