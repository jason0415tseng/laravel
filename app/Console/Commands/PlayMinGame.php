<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MinGameController;
use App\Models\Login;

class PlayMinGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playmingame';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play Min Game';

    private $minGmme;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MinGameController $minGmme)
    {
        parent::__construct();
        $this->minGmme = $minGmme;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('您好，歡迎遊玩小遊戲!!');

        $chiceLogin = $this->choice('請選擇登入或是註冊?', ['登入', '註冊']);

        //註冊&登入 == S ==
        if ($chiceLogin == '登入') {

            $j = 1;
            $request['account'] = '';

            for ($i = 0; $i < $j; $i++) {
                $request['account'] = $this->ask('請輸入帳號?');
                $request['password'] = $this->secret('請輸入密碼?');
                $result = $this->minGmme->login($request);
                // dd($result);
                if ($result['status'] == 2) {
                    $this->error('帳號或密碼錯誤');
                    $j++;
                } else {
                    $request['uid'] = $result['uid'];
                }
            }
        } else {

            $j = 1;
            $request['account'] = '';

            for ($i = 0; $i < $j; $i++) {

                ($request['account'] == '') ? ($request['account'] = $this->ask('請輸入註冊帳號(6碼包含英數)?')) : '';
                $request['password'] = $this->secret('請輸入密碼(8碼包含英數)?');
                $request['password_confirmation'] = $this->secret('請再次輸入密碼?');
                $result = $this->minGmme->createAccount($request);

                if ($result['status'] == 2) {

                    if (isset($result['messages']['account'])) {

                        $this->error($result['messages']['account'][0]);
                        $request['account'] = '';
                        $j++;
                    } elseif (isset($result['messages']['password'])) {

                        $this->error($result['messages']['password'][0]);
                        $j++;
                    }
                }
            }
        }

        //註冊&登入 == E ==

        $k = 1;
        for ($i = 0; $i < $k; $i++) {

            //下注金額 == S ==
            $j = 1;
            for ($i = 0; $i < $j; $i++) {

                $result = $this->minGmme->getUserData($request);
                if( $result['gold'] == 0){
                    $this->info('您餘額不足!!');
                    return;
                }
                $request['betamount'] = $this->ask('您好' . $result['account'] . '，目前餘額:' . number_format($result['gold']) . '，請輸入下注金額(10 ~ 100)');
                $amount = $this->minGmme->checkAmount($request);

                if (isset($amount['status'])) {
                    $this->error($amount['messages']);
                    $j++;
                }
            }

            //下注金額== E ==

            //下注號碼== S ==
            $request['betnumber'] = $this->choice('您好，請選擇下注號碼', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'random']);
            $number = $this->minGmme->checkNumber($request);

            if (isset($number['status'])) {
                $this->error($number['messages']);
            }else{
                $request['betnumber'] = $number['betnumber'];
            }

            //下注號碼== E ==

            //開獎 == S ==
            $this->comment('您的下注金額:' . $request['betamount'] . ', 您的下注號碼:' . $request['betnumber']);
            $all = '5';
            $bar = $this->output->createProgressBar($all);

            $bar->setFormat("開獎中...\n%current%/%max% [%bar%] %percent:3s%%\n");

            foreach (range(1, 5) as $user) {
                sleep(1);
                $bar->advance();
            }

            $bar->finish();

            $winlose = $this->minGmme->lottery($request);

            if ($winlose['status'] == 2) {
                $this->comment('開獎號碼:' . $winlose['lottery']);
                $this->comment($winlose['messages']);
            } else {
                $this->error('開獎號碼:' . $winlose['lottery']);
                $this->error($winlose['messages']);
            }

            //開獎 == E ==

            if ($this->confirm('請問要繼續玩小遊戲嗎?')) {
                $k = $k + 2;
                sleep(0.5);
            } else {
                $this->comment('ByeBye');
                $k = 0;
            }
        }
    }
}
