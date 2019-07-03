<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\DataService;

ini_set('memory_limit', '-1');

class GetWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $dataService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime)
    {
        $this->starttime = $starttime;
        $this->dataService = new DataService;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle()
    {
        $apiLogList = $this->dataService->getApiLog($this->starttime, $from = '', $type = 'apiwagers');
        if (!empty($apiLogList)) {
            foreach (array_chunk($apiLogList, 500, true) as $apiData) {
                $insertData = $this->dataService->checkData($apiData, $type = 'apiwagers');
                if (!empty($insertData)) {
                    $this->dataService->insertData($insertData, $type = 'apiwagers');
                }
            }
        }
    }
}
