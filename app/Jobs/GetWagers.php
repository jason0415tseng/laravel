<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repository\WagersRepository;

ini_set('memory_limit', '-1');

class GetWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $WagersRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime)
    {
        $this->starttime = $starttime;
        $this->WagersRepository = new WagersRepository;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle()
    {
        $apiLogList = $this->WagersRepository->getApiLogList($this->starttime);
        if (!empty($apiLogList)) {
            foreach (array_chunk($apiLogList, 500, true) as $apiData) {
                $insertData = $this->WagersRepository->checkWagers($apiData);
                if (!empty($insertData)) {
                    $this->WagersRepository->insertWagers($insertData);
                }
            }
        }
    }
}
