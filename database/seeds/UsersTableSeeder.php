<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Mario Laserna';
        User::create([
            'name' => $name,
            'email' => 'laserna.mario@gmail.com',
            'slug' => str_slug($name),
            'gender' => 1,
            'avatar' => 'public/defaults/avatars/male.png',
            'password' => bcrypt('12345678'),
            'remember_token' => str_random(10),
        ]);

        factory('App\User', 5)->create();
    }
}
