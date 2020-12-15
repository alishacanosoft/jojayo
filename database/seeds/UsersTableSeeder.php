<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Alisha Lamichhane',
            'email' => 'alisha.coder@gmail.com',
            'contact' => '1234567890',
            'password' => '$2y$10$fPEAzPYFTAJVnZ.AVHrZPOv0ti08jk.VGkeWWQAU6ZKU/w2JH9ozi',
            'roles' => 'admin',
            'image' => 'alisha.jpg'
        ]);
    }
}
