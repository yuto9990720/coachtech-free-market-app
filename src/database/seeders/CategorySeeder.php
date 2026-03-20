<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ファッション'],
            ['name' => 'フード'],
            ['name' => '家電・スマホ・カメラ'],
            ['name' => 'インテリア・住まい・小物'],
            ['name' => 'レディース'],
            ['name' => 'メンズ'],
            ['name' => 'コスメ・香水・美容'],
            ['name' => '本・音楽・ゲーム'],
            ['name' => 'おもちゃ・ホビー・グッズ'],
            ['name' => 'スポーツ・レジャー'],
            ['name' => 'ハンドメイド'],
            ['name' => 'その他'],
        ];

        DB::table('categories')->insert($categories);
    }
}
