<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\CheckWagersService;

class checkWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $checkWagersService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime)
    {
        $this->starttime = $starttime;
        $this->checkWagersService = new CheckWagersService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiLogTotal = $this->checkWagersService->getApiLogTotal($this->starttime);

        if (isset($apiLogTotal['error'])) {
            print_r($apiLogTotal['msg']);
            return;
        } else {
            $apiWagersTotal = $this->checkWagersService->getApiWagersTotal($this->starttime);
        }

        if (isset($apiWagersTotal['error'])) {
            print_r($apiWagersTotal['msg']);
            return;
        } else {
            $checkMsg = $this->checkWagersService->checkWagers($apiLogTotal, $apiWagersTotal);
        }

        if ($checkMsg) {
            print_r($checkMsg['msg']);
            return;
        }
    }
}
