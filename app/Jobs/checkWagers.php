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

class checkWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $endtime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime, $endtime)
    {
        $this->starttime = $starttime;
        $this->endtime = $endtime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 比對總筆數 === S ===
        $apiloglist = apilog::select('*')
            ->whereBetween('created_at', [$this->starttime, $this->endtime])
            ->get();

        $apiloglist = json_decode($apiloglist, true);

        $apilogTotal = count($apiloglist);

        $wagersTotal = apiwagers::select('*')
            ->whereBetween('created_at', [$this->starttime, $this->endtime])
            ->count('*');

        if (!$apilogTotal) {

            Log::info(' === 開始時間 ' . $this->starttime . ' ===');
            Log::error('此時段無任何注單');
            Log::info(' === 結束時間 ' . $this->endtime . ' ===');
            return;
        }

        //比對
        if ($apilogTotal == $wagersTotal) {
            Log::info(' 總筆數 ' . $apilogTotal . ' 筆相同 ');
            return;
        }

        Log::info(' === 開始寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        if ($apilogTotal > $wagersTotal) {
            //寫入DB    
            foreach ($apiloglist as $apilog) {

                $wagers = apiwagers::select('*')
                    ->where('_id', $apilog['_id'])
                    ->whereBetween('created_at', [$this->starttime, $this->endtime])
                    ->first();

                if (is_null($wagers)) {

                    $apiwagers = new apiwagers;

                    $apiwagers->_index = $apilog['_index'];
                    $apiwagers->_type = $apilog['_type'];
                    $apiwagers->_id = $apilog['_id'];
                    $apiwagers->server_name = $apilog['server_name'];
                    $apiwagers->request_method = $apilog['request_method'];
                    $apiwagers->status = $apilog['status'];
                    $apiwagers->size = $apilog['size'];
                    $apiwagers->timestamp = $apilog['timestamp'];

                    $apiwagers->save();

                    //判斷是否寫入成功
                    if (!$apiwagers->save()) {
                        Log::info(' === 寫注單 ' . $apilog['_id'] . ' 失敗 ===');
                    }
                    Log::info(' === 寫注單 ' . $apilog['_id'] . ' ===');
                } else {
                    Log::info(' === 注單 ' . $apilog['_id'] . ' 已存在 ===');
                }
            }
        }
        Log::info(' === 注單總筆數 ' . $apilogTotal . ' ===');
        Log::info(' === 結束寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        return;
        // 比對總筆數 === E ===
    }
}
