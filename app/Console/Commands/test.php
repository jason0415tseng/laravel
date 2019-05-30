<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Login;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:account {user} {--Q|queue=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test account to a user';

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
        $user = $this->argument('user');
        $queue = $this->option('queue');
        $this->line('User是 : ' . $user);
        $this->line('queue是 : ' . $queue);

        $starttime = time();
        $starttime = date("Y-m-d H:i:s", $starttime);
        $this->line('開始時間' . $starttime);

        //顏色表示 == S ==
        $this->info('我是Info');
        $this->comment('我是Comment');
        $this->question('我是Question');
        $this->error('我是Error');
        //顏色表示 == E ==

        //顯示進度條 == S ==
        $all = Login::all();
        $bar = $this->output->createProgressBar(count($all));

        foreach ($all as $user) {
            sleep(1);
            $bar->advance();
        }

        $bar->finish();
        print_r("\n");
        //顯示進度條 == E ==


        //顯示表單 == E ==
        $headers = ['Account', 'Level', 'Name', 'Freeze'];
        $users = Login::all(['account', 'level', 'name', 'freeze'])->toArray();
        $this->table($headers, $users);
        //顯示表單 == E ==

        //互動式輸入 == S ==
        $name = $this->ask('你的名字?');
        $this->comment('你的名字是:' . $name);
        //互動式輸入 == E ==

        //多選題 == S ==
        $account = $this->choice('你的帳號是?', ['Tony', 'Jack', 'God']);
        $this->comment('你的帳號是:' . $account);
        //多選題 == E ==

        //要求確認 == S ==
        if ($this->confirm('請問要繼續嗎?')) {
            echo "YES" . "\n";
        } else {
            echo "NO" . "\n";
        }
        //要求確認 == E ==

        $endtime = time();
        $endtime = date("Y-m-d H:i:s", $endtime);
        $this->line('結束時間' . $endtime);
    }
}
