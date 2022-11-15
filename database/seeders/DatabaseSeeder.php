<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // masteradmin
        DB::table('users')->insert([
            'username'=>'masteradmin',
            'password'=> Hash::make('123456'),
            'first_name'=>'Adam',
            'last_name'=>'Warlock',
            'email'=>'masteradmin@mail.com',
            'role'=>'masteradmin',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        // admin
        /* DB::table('users')->insert([
            'username'=>'admin',
            'password'=> Hash::make('123456'),
            'first_name'=>'Amanda',
            'last_name'=>'Witchcraft',
            'email'=>'admin@mail.com',
            'role'=>'admin',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]); */
        // manager
        /* DB::table('users')->insert([
            'username'=>'manager1',
            'password'=> Hash::make('123456'),
            'first_name'=>'Severus',
            'last_name'=>'Snape',
            'email'=>'manager1@mail.com',
            'role'=>'manager',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]); */
    }
}
