<?php

use Illuminate\Database\Seeder;

class moviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movies')->insert([
            [
                'Mid' => '11',
                'Name' => '輪框公園',
                'Name_en' => 'LanKingPark',
                'Ondate' => '2019-05-16',
                'Type' => '動作',
                'Length' => '90',
                'Grade' => '0',
                'Director' => '輪框',
                'Actor' => '公園',
                'Poster' => '20190510/20190510173817_doctor_strange_ver11_xlg.jpg',
                'Introduction' => '輪框王!!',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '12',
                'Name' => '人面魚',
                'Name_en' => 'FaceFish',
                'Ondate' => '2019-05-31',
                'Type' => '釣魚',
                'Length' => '100',
                'Grade' => '3',
                'Director' => '釣竿',
                'Actor' => '魚餌',
                'Poster' => '20190507/20190507163056_1538050602-799bad5a3b514f096e69bbc4a7896cd9.jpg',
                'Introduction' => '希罵喝加某....',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '13',
                'Name' => '少年金派A奇幻旅程',
                'Name_en' => '8+9',
                'Ondate' => '2019-05-31',
                'Type' => '動作、義氣',
                'Length' => '110',
                'Grade' => '2',
                'Director' => '少年',
                'Actor' => '八加九',
                'Poster' => '20190506/20190506180028_LOPi_campD_HKposter_06_1350654431.jpg',
                'Introduction' => '你在大聲什麼!!!!',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '14',
                'Name' => '雞惡遊戲',
                'Name_en' => 'ChickeNevilGame',
                'Ondate' => '2019-05-29',
                'Type' => '益智',
                'Length' => '100',
                'Grade' => '4',
                'Director' => '惡',
                'Actor' => '雞',
                'Poster' => '20190506/20190506180823_hunger-games-catching-fire-poster-28.jpg',
                'Introduction' => '史上最大的.....',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '15',
                'Name' => '瘋狂甲麵',
                'Name_en' => 'CrazyEatMian',
                'Ondate' => '2019-05-26',
                'Type' => '動作',
                'Length' => '240',
                'Grade' => '3',
                'Director' => '瘋狂',
                'Actor' => '甲麵',
                'Poster' => '20190507/20190507102303_6608477199794840863.jpg',
                'Introduction' => '甲甲甲甲甲甲甲甲甲',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '16',
                'Name' => '大象',
                'Name_en' => 'a了粉',
                'Ondate' => '2019-05-31',
                'Type' => '歡樂',
                'Length' => '111',
                'Grade' => '2',
                'Director' => '大象',
                'Actor' => '大象',
                'Poster' => '20190507/20190507163403_234_big.jpg',
                'Introduction' => '大~象你的耳朵怎麼那~~麼長~~~',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '18',
                'Name' => '換數',
                'Name_en' => 'ChangeNumber',
                'Ondate' => '2019-06-01',
                'Type' => '懸疑',
                'Length' => '120',
                'Grade' => '1',
                'Director' => '阿珍',
                'Actor' => '阿扁',
                'Poster' => '20190508/20190508110938_276_big.jpg',
                'Introduction' => '去找吧!所有的財寶我都放在那了!!',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '19',
                'Name' => '皮卡秋',
                'Name_en' => 'PeCaC',
                'Ondate' => '2019-06-22',
                'Type' => '劇情',
                'Length' => '113',
                'Grade' => '2',
                'Director' => '神奇海螺',
                'Actor' => '秋喔',
                'Poster' => '20190508/20190508122634_film_20190411019.jpg',
                'Introduction' => '皮康鳩拉',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'Mid' => '20',
                'Name' => '怪獸與他們買地',
                'Name_en' => 'MonsterBuyLand',
                'Ondate' => '2019-06-11',
                'Type' => '懸疑、劇情',
                'Length' => '105',
                'Grade' => '1',
                'Director' => '地主',
                'Actor' => '怪獸',
                'Poster' => '20190508/20190508122311_TMunAd1.jpg',
                'Introduction' => '老闆我想買地!!',
                'Display' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],

        ]);
    }
}