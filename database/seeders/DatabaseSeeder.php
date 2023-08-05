<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::table('users')->delete();

        // // //Entry for Admin
        $user = User::create([
            'username' => 'Admin',
            'email' => 'admin.dev@gmail.com',
            'password' => Hash::make('password'),
            'dob' => '2023-08-05',
            'role_id' => 1,
        ]);

        // Role::create([
        //     'role_name' => 'Admin'
        // ]);
        // Role::create([
        //     'role_name' => 'URM Candidate'
        // ]);
        // Role::create([
        //     'role_name' => 'Academia'
        // ]);
        // Role::create([
        //     'role_name' => 'Del Officer'
        // ]);
        // Role::create([
        //     'role_name' => 'Recruiter'
        // ]);
    }
}