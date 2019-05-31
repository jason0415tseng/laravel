<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MinGameController;

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

        if ($chiceLogin == '登入') {

            $account = $this->ask('請輸入帳號?');
        } else {

            $j = 1;

            for ($i = 0; $i < $j; $i++) {

                $request['account'] = $this->ask('請輸入註冊帳號(6碼包含英數)?');
                $request['password'] = $this->secret('請輸入密碼(8碼包含英數)?');
                $request['password_confirmation'] = $this->secret('請再次輸入密碼?');
                $result = $this->minGmme->createAccount($request);

                if (isset($result['account'])) {

                    $this->error($result['account'][0]);
                    $j++;
                } elseif (isset($result['password'])) {

                    $this->error($result['password'][0]);
                }
            }
        }
    }
}
