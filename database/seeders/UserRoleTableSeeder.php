<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Rano;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::all() as $user) {
            foreach(Role::all() as $role) {
                if ($user->id == 1 && $role->slug == 'root') {
                    $user->roles()->attach($role->id);
                    $user->email = 'admin@admin.ru';
                    $user->role_id = $role->id;
                    $user->name = 'Бокова Эсет Ибрагимовна';
                    $user->phone = '+7 (8732) 22-24-57';
                }
                if ($user->id > 1 && $role->slug == 'admin') {
                    $user->roles()->attach($role->id);
                    $user->role_id = $role->id;
                    $user->is_director = true;
                }
                if ($user->id > 10 && $role->slug == 'user') {
                    $user->roles()->attach($role->id);
                    $user->role_id = $role->id;
                }

                $user->save();
            }
        }
    }
}
