<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['slug' => 'manage-users', 'name' => 'Управление пользователями'],
            ['slug' => 'create-user', 'name' => 'Создание пользователя'],
            ['slug' => 'edit-user', 'name' => 'Редактирование пользователя'],
            ['slug' => 'delete-user', 'name' => 'Удаление пользователя'],

            ['slug' => 'manage-roles', 'name' => 'Управление ролями пользователей'],
            ['slug' => 'create-role', 'name' => 'Создание роли пользователя'],
            ['slug' => 'edit-role', 'name' => 'Редактирование роли пользователя'],
            ['slug' => 'delete-role', 'name' => 'Удаление роли пользователя'],

            ['slug' => 'assign-role', 'name' => 'Назначение роли для пользователя'],
            ['slug' => 'assign-permission', 'name' => 'Назначение права для пользователя'],

            ['slug' => 'manage-gunos', 'name' => 'Управление ГУНО'],
            ['slug' => 'create-guno', 'name' => 'Создание ГУНО'],
            ['slug' => 'edit-guno', 'name' => 'Редактирование ГУНО'],
            ['slug' => 'delete-guno', 'name' => 'Удаление ГУНО'],

            ['slug' => 'manage-ranos', 'name' => 'Управление РОО'],
            ['slug' => 'create-rano', 'name' => 'Создание РОО'],
            ['slug' => 'edit-rano', 'name' => 'Редактирование РОО'],
            ['slug' => 'delete-rano', 'name' => 'Удаление РОО'],

            ['slug' => 'manage-schools', 'name' => 'Управление школами'],
            ['slug' => 'create-school', 'name' => 'Создание школы'],
            ['slug' => 'edit-school', 'name' => 'Редактирование школы'],
            ['slug' => 'delete-school', 'name' => 'Удаление школы'],
        ];
        foreach ($permissions as $item) {
            $permission = new Permission();
            $permission->name = $item['name'];
            $permission->slug = $item['slug'];
            $permission->save();
        }
    }
}
