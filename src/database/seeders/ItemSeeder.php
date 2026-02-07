<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Item::insert([
            [
            'user_id' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'items/Armani_Mens_Clock.jpg',
            'condition' => '良好',
            'category_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'user_id' => 2,
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'items/HDD_Hard_Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'user_id' => 3,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path' => 'items/iLoveIMG_d.jpg',
            'condition' => 'やや傷や汚れあり',
            'category_id' => 10,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'user_id' => 4,
            'name' => '革靴',
            'price' => 4000,
            'brand' => null,
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'items/Leather_Shoes_Product_Photo.jpg',
            'condition' => '状態が悪い',
            'category_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'image_path' => 'items/Living_Room_Laptop.jpg',
                'condition' => '良好',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'items/Music+Mic+4632231.jpg',
                'condition' => '目立った傷や汚れなし',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'items/Purse_fashion_pocket.jpg',
                'condition' => 'やや傷や汚れあり',
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'image_path' => 'items/Tumbler_souvenir.jpg',
                'condition' => '状態が悪い',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 9,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image_path' => 'items/Waitress_with_Coffee_Grinder.jpg',
                'condition' => '良好',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'image_path' => 'items/makeup-set.jpg',
                'condition' => '目立った傷や汚れなし',
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
