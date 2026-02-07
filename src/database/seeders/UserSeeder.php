<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'dummy@example.com'],
            [
                'name' => 'ダミーユーザー',
                'password' => Hash::make('password'),
            ]
        );
    }
}
