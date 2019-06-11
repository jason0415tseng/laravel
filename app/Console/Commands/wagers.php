<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\betlog;
use App\Models\wagersDB;
use Illuminate\Support\Facades\Log;
use App\Jobs\InsertWagers;

class wagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wagers:insert {--S|starttime= : format: 2019-05-01T00:00:00}  {--E|endtime= : format: 2019-05-01T23:59:59}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Betlog to Wagers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //時間
        $starttime = $this->option('starttime');
        $endtime = $this->option('endtime');

        //時間判斷
        if (empty($endtime)) {
            $endtime = date('Y-m-d H:i', strtotime($starttime)) . ':59';
            $endtime = str_replace(' ', 'T', $endtime);
        }

        if ($starttime > $endtime) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('結束時間請勿小於開始時間');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        if ($starttime == $endtime) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('結束時間請勿等於開始時間');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        $job = new InsertWagers($starttime, $endtime);
        dispatch($job);

        //比對總筆數 & 總下注金額 === S ===
        $betloglist = betlog::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->get();

        $betlogTotalGold = betlog::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->sum('betgold');

        $betloglist = json_decode($betloglist, true);

        $betlogTotal = count($betloglist);

        $wagersTotal = wagersDB::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->count('*');

        $wagersTotalGold = wagersDB::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->sum('betgold');


        if (!$betlogTotal && !$betlogTotalGold) {

            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('此時段無任何注單');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        //比對
        if ($betlogTotal == $wagersTotal && $betlogTotalGold == $wagersTotalGold) {
            $this->info(' 總筆數 ' . $betlogTotal . ' 筆相同 ');
            return;
        }

        $this->info(' === 開始寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        if ($betlogTotal > $wagersTotal && $betlogTotalGold > $wagersTotalGold) {
            //寫入DB    
            foreach ($betloglist as $betlog) {

                $wagers = wagersDB::select('*')
                    ->where('gameid', $betlog['GameId'])
                    ->whereBetween('bettime', [$starttime, $endtime])
                    ->first();

                if ($wagers == null) {

                    $wagerDB = new wagersDB;

                    $wagerDB->gameid = $betlog['GameId'];
                    $wagerDB->uid = $betlog['Uid'];
                    $wagerDB->account = $betlog['Account'];
                    $wagerDB->betnumber = $betlog['BetNumber'];
                    $wagerDB->lottery = $betlog['Lottery'];
                    $wagerDB->betgold = $betlog['BetGold'];
                    $wagerDB->wingold = $betlog['WinGold'];
                    $wagerDB->bettime = $betlog['BetTime'];

                    $wagerDB->save();

                    //判斷是否寫入成功
                    if (!$wagerDB->save()) {
                        $this->info(' === 寫注單 ' . $betlog['GameId'] . ' 失敗 ===');
                    }
                    $this->info(' === 寫注單 ' . $betlog['GameId'] . ' ===');
                } else {
                    $this->info(' === 注單 ' . $betlog['GameId'] . ' 已存在 ===');
                }
            }
        }
        $this->info(' === 注單總筆數 ' . $betlogTotal . ' ===');
        $this->info(' === 結束寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        return;
        //比對總筆數 & 總下注金額 === E ===
    }
}
