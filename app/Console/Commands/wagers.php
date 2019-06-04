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
            $starttime ? $starttime = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($starttime))) : $starttime = date('Y-m-d' . ' 00:00:00');
            $endtime ? $endtime = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($endtime))) : $endtime = date('Y-m-d' . ' 23:59:59');
        } else {
            $date ? $starttime = $date . ' ' . $starttime : $starttime = date('Y-m-d ' . $starttime);
            $date ? $endtime = $date . ' '  . $endtime : $endtime = date('Y-m-d ' . $endtime);
        }

        if ($starttime > $endtime) {
            Log::info(' === 開始時間 ' . $starttime . ' ===');
            $this->info('結束時間請勿小於開始時間');
            Log::info('結束時間請勿小於開始時間');
            Log::info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        $betloglist = betlog::select('*')
            ->whereBetween('bettime', [$starttime, $endtime])
            ->get();

        $betloglist = json_decode($betloglist, true);

        if (!$betloglist) {
            Log::info(' === 開始時間 ' . $starttime . ' ===');
            $this->info('此時段無任何注單');
            Log::info('此時段無任何注單');
            Log::info(' === 結束時間 ' . $endtime . ' ===');
            return;
        }

        foreach ($betloglist as $betlog) {

            $wagers = wagersDB::select('*')
                ->where('gameid', $betlog['GameId'])
                ->first();

            if ($wagers == null) {

                Log::info(' === 開始寫注單 ' . $starttime . ' ===');

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

                $this->info(' === 寫注單' . $betlog['GameId'] . ' ===');
                Log::info(' === 寫注單 ' . $betlog['GameId'] . ' ===');
                Log::info(' === 結束寫注單 ' . $endtime . ' ===');
            } else {
                $this->info(' === 注單 ' . $betlog['GameId'] . ' 已存在 ===');
                Log::info(' === 注單 ' . $betlog['GameId'] . ' 已存在 ===');
            }
        }
    }
}
