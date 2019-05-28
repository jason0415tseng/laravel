<?php

use Illuminate\Database\Seeder;

class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            [
                'Uid' => '1',
                'Level' => '0',
                'Account' => 'admin1',
                'Password' => 'YWRtaW4xMjM=',
                'Name' => 'admin1',
                'Freeze' => 'Y',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Uid' => '2',
                'Level' => '3',
                'Account' => 'asd123',
                'Password' => 'YXNkMTIzNDU=',
                'Name' => 'asd123',
                'Freeze' => 'Y',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Uid' => '3',
                'Level' => '3',
                'Account' => 'wsx123',
                'Password' => 'd3N4MTIzNDU=',
                'Name' => 'wsx123',
                'Freeze' => 'Y',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
