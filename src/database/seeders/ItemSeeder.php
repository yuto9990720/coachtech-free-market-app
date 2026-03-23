<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        
        $items = [
            [
                'name'         => '腕時計',
                'brand'        => 'Rolax',
                'description'  => 'スタイリッシュなデザインのメンズ腕時計',
                'price'        => 15000,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'condition_id' => 1, // 良好
                'category_ids' => [6], // メンズ
            ],
            [
                'name'         => 'HDD',
                'brand'        => '西芝',
                'description'  => '高速で信頼性の高いハードディスク',
                'price'        => 5000,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
                'category_ids' => [3], // 家電・スマホ・カメラ
            ],
            [
                'name'         => '玉ねぎ3束',
                'brand'        => null,
                'description'  => '新鮮な玉ねぎ3束のセット',
                'price'        => 300,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'condition_id' => 3, // やや傷や汚れあり
                'category_ids' => [2], // フード
            ],
            [
                'name'         => '革靴',
                'brand'        => null,
                'description'  => 'クラシックなデザインの革靴',
                'price'        => 4000,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'condition_id' => 4, // 状態が悪い
                'category_ids' => [6], // メンズ
            ],
            [
                'name'         => 'ノートPC',
                'brand'        => null,
                'description'  => '高性能なノートパソコン',
                'price'        => 45000,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'condition_id' => 1, // 良好
                'category_ids' => [3], // 家電・スマホ・カメラ
            ],
            [
                'name'         => 'マイク',
                'brand'        => null,
                'description'  => '高音質のレコーディング用マイク',
                'price'        => 8000,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
                'category_ids' => [8], // 本・音楽・ゲーム
            ],
            [
                'name'         => 'ショルダーバッグ',
                'brand'        => null,
                'description'  => 'おしゃれなショルダーバッグ',
                'price'        => 3500,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'condition_id' => 3, // やや傷や汚れあり
                'category_ids' => [5], // レディース
            ],
            [
                'name'         => 'タンブラー',
                'brand'        => null,
                'description'  => '使いやすいタンブラー',
                'price'        => 500,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'condition_id' => 4, // 状態が悪い
                'category_ids' => [4], // インテリア・住まい・小物
            ],
            [
                'name'         => 'コーヒーミル',
                'brand'        => 'Starbacks',
                'description'  => '手動のコーヒーミル',
                'price'        => 4000,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'condition_id' => 1, // 良好
                'category_ids' => [4], // インテリア・住まい・小物
            ],
            [
                'name'         => 'メイクセット',
                'brand'        => null,
                'description'  => '便利なメイクアップセット',
                'price'        => 2500,
                'image'        => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
                'category_ids' => [7], // コスメ・香水・美容
            ],
        ];

        foreach ($items as $index => $itemData) {
            $categoryIds = $itemData['category_ids'];
            unset($itemData['category_ids']);

            // ユーザー1が1〜5番、ユーザー2が6〜10番を出品
            $itemData['user_id'] = ($index < 5) ? 1 : 2;

            $item = Item::create($itemData);
            $item->categories()->attach($categoryIds);
        }
    }
}
