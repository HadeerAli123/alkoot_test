<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
 
class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('themes')->insert([
        [
            'name' => 'electron',
            'image' => 'themes/electron.jpeg',
             'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'hotels',
            'image' => 'themes/hotels.jpeg',
             'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ],
        [
            'name' => 'tmweal',
            'image' => 'themes/tmweal.jpeg',
             'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ],
        [
            'name' => 'elkoot',
            'image' => 'themes/elkoot.jpeg',
             'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]
    ]);
    }
}
