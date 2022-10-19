<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);
        $this->command->info('Таблица ролей загружена данными!');
        $this->call(UserTableSeeder::class);
        $this->command->info('Таблица пользователей загружена данными!');
        $this->call(UserRoleTableSeeder::class);
        $this->command->info('Таблица пользователь-право загружена данными!');

    }
}
