<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            ['slug' => 'root', 'name' => 'Администратор', 'title' => 'Администратор системы'],
            ['slug' => 'user', 'name' => 'Пользователь', 'title' => 'Пользователь'],
        ];
        foreach ($roles as $item)
        {
            $role = new Role();
            $role->name = $item['name'];
            $role->title = $item['title'];
            $role->description = $item['name'];
            $role->slug = $item['slug'];
            $role->save();
        }
    }
}
