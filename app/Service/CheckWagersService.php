<?php

namespace App\Service;

use App\Repository\CheckWagersRepository;
use Illuminate\Support\Facades\Log;

class CheckWagersService
{
    protected $checkWagersRepo;

    // 透過 DI 注入 Repository
    public function __construct()
    {
        $this->checkWagersRepo = new CheckWagersRepository;
    }

    //確認資料
    public function getApiLogTotal($starttime)
    {
        $apiLogTotal = $this->checkWagersRepo->getApiLogTotal($starttime);
        if (!$apiLogTotal) {
            print_r('此時段 ApiLog 無任何注單' . "\n");
            return false;
        }
        return $apiLogTotal;
    }

    //確認資料
    public function getApiWagersTotal($starttime)
    {
        $apiWagersTotal = $this->checkWagersRepo->getApiWagersTotal($starttime);
        if (!$apiWagersTotal) {
            print_r('此時段 ApiWagers 無任何注單' . "\n");
            return false;
        }
        return $apiWagersTotal;
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        if (!empty($apiLogTotal) && !empty($apiWagersTotal)) {
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
