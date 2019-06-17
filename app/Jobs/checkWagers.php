<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\apilog;
use App\Models\apiwagers;
use Illuminate\Support\Facades\Log;
use App\Service\CheckWagersService;

class checkWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $endtime;
    protected $checkWagersService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime, $endtime)
    {
        $this->starttime = $starttime;
        $this->endtime = $endtime;
        $this->checkWagersService = new CheckWagersService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $params = [
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
        ];

        $this->checkWagersService->checkWagers($params);
    }
}
