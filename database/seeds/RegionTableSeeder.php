<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         DB::table('regions')->insert([
             [
             'name' => 'Mechi'
         ],[
             'name' => 'Koshi'
         ],[
             'name' => 'Sagarmatha'
         ],[
             'name' => 'Janakpur'
         ],[
             'name' => 'Bagmati'
         ],[
             'name' => 'Narayani'
         ],[
             'name' => 'Gandaki'
         ],[
             'name' => 'Lumbini'
         ],[
             'name' => 'Dhaulagiri'
         ],[
             'name' => 'Rapti'
         ],[
             'name' => 'Bheri'
         ],[
             'name' => 'Karnali'
         ],[
             'name' => 'Seti'
         ],[
             'name' => 'Mahakali'
         ]
       ]
     );
     }
}
