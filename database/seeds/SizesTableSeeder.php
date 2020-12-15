<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            [
            'name' => 'XS',
            'slug' => 'xs'
        ],[
            'name' => 'S',
            'slug' => 's'
        ],[
            'name' => 'L',
            'slug' => 'l'
        ],[
            'name' => 'XL',
            'slug' => 'xl'
        ],[
            'name' => 'XXL',
            'slug' => 'xxl'
        ],[
            'name' => 'XXL',
            'slug' => 'xxl'
        ]]
    );
    }
}
