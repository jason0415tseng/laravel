<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repository\CheckWagersRepository;
use Illuminate\Support\Facades\Log;

class checkWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $checkWagersRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime)
    {
        $this->starttime = $starttime;
        $this->checkWagersRepository = new CheckWagersRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiLogTotal = $this->checkWagersRepository->getApiLogTotal($this->starttime);
        if (!empty($apiLogTotal)) {
            $apiWagersTotal = $this->checkWagersRepository->getApiWagersTotal($this->starttime);
            if (!empty($apiWagersTotal)) {
                //比對
                if ($apiLogTotal == $apiWagersTotal) {
                    Log::info(' ApiLog & ApiWagers 總筆數 ' . $apiLogTotal . ' 筆相同 ');
                    print_r(' ApiLog & ApiWagers 總筆數 ' . $apiLogTotal . ' 筆相同 ' . "\n");
                }

                if ($apiLogTotal > $apiWagersTotal) {

                    Log::info(' ApiLog 總筆數: ' . $apiLogTotal . ' 筆');
                    Log::info(' ApiWagers 總筆數: ' . $apiWagersTotal . ' 筆');
                    Log::info(' 筆數: ' . ($apiLogTotal - $apiWagersTotal) . ' 筆不相同');

                    $msg = ' ApiLog 總筆數: ' . $apiLogTotal . ' 筆' . "\n";
                    $msg .= (' ApiWagers 總筆數: ' . $apiWagersTotal . ' 筆') . "\n";
                    $msg .= (' 筆數: ' . ($apiLogTotal - $apiWagersTotal) . ' 筆不相同') . "\n";

                    print_r($msg);
                }
            }
        }
    }
}
