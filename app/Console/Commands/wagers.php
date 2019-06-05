<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\betlog;
use App\Models\wagersDB;
use Illuminate\Support\Facades\Log;

class wagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wagers:insert {date=0 format : 2019-05-01} {--S|starttime=00:00:00} {--E|endtime=23:59:59}';

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
        $date = $this->argument('date');
        $starttime = $this->option('starttime');
        $endtime = $this->option('endtime');

        //時間判斷
        if ($date == 0) {
            $starttime ? $starttime = date('Y-m-d ' . $starttime) : $starttime = date('Y-m-d' . ' 00:00:00');
            $endtime ? $endtime = date('Y-m-d ' . $endtime) : $endtime = date('Y-m-d' . ' 23:59:59');
        } else {
            $date ? $starttime = $date . ' ' . $starttime : $starttime = date('Y-m-d ' . $starttime);
            $date ? $endtime = $date . ' '  . $endtime : $endtime = date('Y-m-d ' . $endtime);
        }

        if ($starttime > $endtime) {
            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('結束時間請勿小於開始時間');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        //比對方式一:總筆數 === S ===
        $betloglist = betlog::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->get();

        $betloglist = json_decode($betloglist, true);

        $betlogTotal = count($betloglist);

        if (!$betlogTotal) {

            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('此時段無任何注單');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        $wagersTotal = wagersDB::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->count('*');

        //比對總筆數
        if ($betlogTotal == $wagersTotal) {
            $this->info(' 總筆數相同 ');
            return;
        }

        $this->info(' === 開始寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        if ($betlogTotal > $wagersTotal) {
            //寫入DB    
            foreach ($betloglist as $betlog) {

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
            }
        }

        $this->info(' === 結束寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        return;
        //比對方式一:總筆數 === E ===

        //比對方式一:總下注金額 === S ===
        $betlogTotalGold = betlog::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->sum('betgold');

        if (!$betlogTotalGold) {

            $this->info(' === 開始時間 ' . $starttime . ' ===');
            $this->error('此時段無任何注單');
            $this->info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        $wagersTotalGold = wagersDB::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->sum('betgold');

        //比對總下注金額
        if ($betlogTotalGold == $wagersTotalGold) {
            $this->info(' 總金額相同 ');
            return;
        }

        $this->info(' === 開始寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        if ($betlogTotalGold > $wagersTotalGold) {
            //寫入DB
            $betloglist = betlog::select('*')
                ->whereBetween('bettime', [$starttime, $endtime])
                ->get();

            $betloglist = json_decode($betloglist, true);

            foreach ($betloglist as $betlog) {

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
            }
        }

        $this->info(' === 結束寫注單 ' . date('Y-m-d H:i:s') . ' ===');

        return;
        //比對方式一:總下注金額 === E ===
    }
}
