<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
        [
            'name' => 'Red'
        ],[
            'name' => 'Yellow'
        ],[
            'name' => 'Blue'
        ],[
            'name' => 'Black'
        ],[
            'name' => 'White'
        ],[
            'name' => 'Orange'
        ],[
            'name' => 'Maroon'
        ],[
            'name' => 'Pink'
        ],[
            'name' => 'Royal blue'
        ],[
            'name' => 'Navy blue'
        ],[
            'name' => 'Purple'
        ],[
            'name' => 'Lime'
        ],[
            'name' => 'Green'
        ],[
            'name' => 'Ocean blue'
        ],[
            'name' => 'Aqua'
        ],[
            'name' => 'Plum'
        ],[
            'name' => 'Poppy red'
        ],[
            'name' => 'Coral rose'
        ],[
            'name' => 'Coral'
        ],[
            'name' => 'Light Pink'
        ],[
            'name' => 'Pearl Pink'
        ],[
            'name' => 'Bubblegum Pink'
        ],[
            'name' => 'Hot Pink'
        ],[
            'name' => 'Shocking Pink'
        ],[
            'name' => 'Wine'
        ],[
            'name' => 'Fuchsia'
        ],[
            'name' => 'Tropic'
        ],[
            'name' => 'Cobalt'
        ],[
            'name' => 'Capri Blue'
        ],[
            'name' => 'Jade'
        ],[
            'name' => 'Teal'
        ],[
            'name' => 'Light Orchid'
        ],[
            'name' => 'Lavender'
        ],[
            'name' => 'Grape'
        ],[
            'name' => 'Mint'
        ]
        ]
    );
    }
}
