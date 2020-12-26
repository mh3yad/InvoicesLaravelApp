<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
           'name'=>'manager',
           'email'=>'manager@gmail.com',
           'status'=>'1',
           'password'=>\Illuminate\Support\Facades\Hash::make('123')
       ]);
//        DB::table('sections')->insert([
//            'section_name'=>'section',
//            'created_by'=>'sayed'
//
//        ]);
//        DB::table('products')->insert([
//            'section_id'=>1,
//            'product_name'=>'sayed',
//            'created_by'=>'hassan'
//
//        ]);
    }
}
