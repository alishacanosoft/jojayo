<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commissions')->insert([
            [
            'price-range' => '1-1500'
        ],[
            'price-range' => '1501-3000'
        ],[
            'price-range' => '3001-4500'
        ],[
            'price-range' => '4501-6000'
        ],[
            'price-range' => '6001-10,000'
        ],[
            'price-range' => '10,001-20,000'
        ],[
            'price-range' => '20,000-above'
        ]]
    );
    }
}
