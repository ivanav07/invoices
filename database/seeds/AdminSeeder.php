<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email      = 'vaska986@gmail.com';
        $password   = '11111111';
        $first_name = 'Ivana';
        $last_name  = 'Vasic';
        $admin      = \App\User::where('email', $email)->first();
        if (!$admin)
        {
            DB::table('users')->insert([
                'email'      => $email,
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'password'   => bcrypt($password),
                'admin'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
