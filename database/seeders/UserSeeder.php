<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seeder for role user
        User::create([
            'nama'=>'user1',
            'alamat'=>'bali',
            'no_telp'=>'081890987765',
            'role'=>'user',
            'email'=>'user1@gmail.com',
            'password' => bcrypt('user1'),
        ]);

        // seeder for role admin
        User::create([
            'nama'=>'admin1',
            'alamat'=>'bali',
            'no_telp'=>'081890987765',
            'role'=>'admin',
            'email'=>'admin1@gmail.com',
            'password' => bcrypt('admin1'),
        ]);
    }
}
