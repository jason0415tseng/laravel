<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class insert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test insert';

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
        DB::table('log')
            ->insert([
                'time' => date('Y-m-d H:i:s')
            ]);
        Log::info('test時間 : ' . date('Y-m-d H:i:s'));
    }
}
