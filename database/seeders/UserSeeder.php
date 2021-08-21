<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'TAHUNGODING',
            'username' => 'tahungoding',
            'email' => 'tahungoding@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $role = Role::create(['name' => 'admin']);
        $user->assignRole([$role->id]);

        $user2 = User::create([
            'name' => 'INIMAHSUMEDANG',
            'username' => 'inimahsumedang',
            'email' => 'inimahsumedang@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $role2 = Role::create(['name' => 'guest']);
        $user2->assignRole([$role2->id]);
    }
}
