<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->count() != 0) {
            return;
        }

        DB::table('users')
            ->insert([
                [
                    'name' => 'admin',
                    'email' => 'admin@test.loc',
                    'password' => Hash::make('password'),
                ],
            ]);

        factory('App\User', 15)
            ->create();
    }
}
