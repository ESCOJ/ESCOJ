<?php

use Illuminate\Database\Seeder;
use EscojLB\Repo\User\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(array(
            'name' => 'Admin',
            'last_name' => 'ESCOJ',
            'nickname' => 'papilord',
            'email' => 'esc.onlinejudge@gmail.com',
            'password' => bcrypt('123456'),
            'register_date' => date("Y/m/d"),
            'type' => 'admin',
            'institution_id' => 1,
            'institution_id' => 1,
            'country_id' => 1,
            'avatar' => 'user_default.jpg',
            'confirmed' => 1,

        ));
        /*User::create(array(
            'name' => 'Miguel Angel',
            'last_name' => 'Mandujano Diaz',
            'nickname' => 'mickemandujas',
            'email' => 'mickemandu@outlook.com',
            'password' => bcrypt('123456'),
            'register_date' => date("Y/m/d"),
            'type' => 'admin',
            'institution_id' => 1,
            'country_id' => 1,
            'confirmed' => 1,
        ));*/
    }
}
