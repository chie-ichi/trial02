<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            for($j = ($i % 3) + 1; $j <= 20; $j+=3){
                $param = [
                    'user_id' => $i,
                    'restaurant_id' => $j,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                DB::table('favorites')->insert($param);
            }
        }
    }
}
