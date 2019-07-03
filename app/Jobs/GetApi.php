<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\DataService;

ini_set('memory_limit', '-1');

class GetApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $from;
    protected $total;
    protected $dataService;

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
        $this->dataService = new DataService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        while ($this->from <= $this->total) {
            $apiLogData = $this->dataService->getApiLog($this->starttime, $this->from, $type = 'apilog');
            if (!empty($apiLogData)) {
                $checkData = $this->dataService->checkData($apiLogData, $type = 'apilog');
                if (!empty($checkData)) {
                    $this->dataService->insertData($checkData['insertData'], $type = 'apilog');
                    $this->dataService->updateData($checkData['updateData'], $type = 'apilog');
                    $this->total = $apiLogData['hits']['total'];
                    $this->from += 10000;
                }
            } else {
                return;
            }
        }
    }
}
