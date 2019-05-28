<?php

use Illuminate\Database\Seeder;

class timeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('time')->insert([
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '10:00',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '11:50',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '13:40',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '15:30',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '17:20',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '19:10',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '11',
                'Hall' => '7',
                'Time' => '21:00',
                'Seat' => '200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
