<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (User::all() as $user)
        {
            foreach (Role::all() as $role)
            {
                if ($user->id == 1 && $role->slug == 'root')
                {
                    $user->roles()->attach($role->id);
                    $user->email = 'admin@admin.com';
                    $user->role_id = $role->id;
                    $user->name = 'Rustam Siraev';
                    $user->phone = '+7 (917) 807-66-39';
                }
                elseif ($user->id > 1 && $role->slug == 'user')
                {
                    $user->roles()->attach($role->id);
                    $user->role_id = $role->id;
                }

                $user->save();
            }
        }
    }
}
