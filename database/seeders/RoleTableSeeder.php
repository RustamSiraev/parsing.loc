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
    public function run()
    {
        $roles = [
            ['slug' => 'root', 'name' => 'Администратор', 'title' => 'Администратор системы'],
            ['slug' => 'admin', 'name' => 'Администратор СПО', 'title' => 'Администратор учебного заведения'],
            ['slug' => 'college', 'name' => 'Секретарь СПО', 'title' => 'Секретарь учебного заведения'],
            ['slug' => 'user', 'name' => 'Абитуриент', 'title' => 'Абитуриент'],
        ];
        foreach ($roles as $item) {
            $role = new Role();
            $role->name = $item['name'];
            $role->title = $item['title'];
            $role->description = $item['name'];
            $role->slug = $item['slug'];
            $role->save();
        }
    }
}
