<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //DB::table('category_item')->truncate();
        //DB::table('items')->truncate();
        $userId = User::first()->id;

            $item = Item::create([
            'user_id' => $userId,
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'items/Armani_Mens_Clock.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
            ]);
            $item->categories()->attach([5]);
            
            $item = Item::create([
            'user_id' => $userId,
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'items/HDD_Hard_Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'created_at' => now(),
            'updated_at' => now(),
            ]);
            $item->categories()->attach([2]);
            
            $item = Item::create([
            'user_id' => $userId,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path' => 'items/iLoveIMG_d.jpg',
            'condition' => 'やや傷や汚れあり',
            'created_at' => now(),
            'updated_at' => now(),
            ]);
            $item->categories()->attach([10]);

            $item =Item::create([
            'user_id' => $userId,
            'name' => '革靴',
            'price' => 4000,
            'brand' => null,
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'items/Leather_Shoes_Product_Photo.jpg',
            'condition' => '状態が悪い',
            'created_at' => now(),
            'updated_at' => now(),
            ]);
            $item->categories()->attach([5]);

            $item = Item::create([
                'user_id' => $userId,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'image_path' => 'items/Living_Room_Laptop.jpg',
                'condition' => '良好',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $item->categories()->attach([2]);

            $item = Item::create([
                'user_id' => $userId,
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'items/Music_Mic_4632231.jpg',
                'condition' => '目立った傷や汚れなし',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $item->categories()->attach([2]);

            $item = Item::create([
                'user_id' => $userId,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'items/Purse_fashion_pocket.jpg',
                'condition' => 'やや傷や汚れあり',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $item->categories()->attach([4]);

            $item = Item::create([
                'user_id' => $userId,
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'image_path' => 'items/Tumbler_souvenir.jpg',
                'condition' => '状態が悪い',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $item->categories()->attach([2]);

            $item = Item::create([
                'user_id' => $userId,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image_path' => 'items/Waitress_with_Coffee_Grinder.jpg',
                'condition' => '良好',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $item->categories()->attach([2]);

            $item = Item::create([
                'user_id' => $userId,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'image_path' => 'items/makeup-set.jpg',
                'condition' => '目立った傷や汚れなし',
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        $item->categories()->attach([4]);
    }
}
