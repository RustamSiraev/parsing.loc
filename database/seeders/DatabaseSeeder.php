<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->command->info('Таблица ролей загружена данными!');
        $this->call(UserTableSeeder::class);
        $this->command->info('Таблица пользователей загружена данными!');
        $this->call(CollegesTableSeeder::class);
        $this->command->info('Таблица учебных заведений загружена данными!');
        $this->call(UserRoleTableSeeder::class);
        $this->command->info('Таблица пользователь-право загружена данными!');
        $this->call(StreetsTableSeeder::class);
        $this->command->info('Таблица улиц загружена данными!');
        $this->call(HousesTableSeeder::class);
        $this->command->info('Таблица домов загружена данными!');
        $this->call(ApplicantsTableSeeder::class);
        $this->command->info('Таблица абитуриентов загружена данными!');
        $this->call(StatementStatusesTableSeeder::class);
        $this->command->info('Таблица статусов заявлений загружена данными!');
        $this->call(StatementsTableSeeder::class);
        $this->command->info('Таблица заявлений загружена данными!');
        $this->call(DiplomasTableSeeder::class);
        $this->command->info('Таблица аттестатов загружена данными!');
        $this->call(SpecialityTableSeeder::class);
        $this->command->info('Таблица специальностей и квалификаций загружена данными!');
        $this->call(StatementsTableSeeder::class);
        $this->command->info('Таблица заявлений загружена данными!');
    }
}
