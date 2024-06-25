<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 20; $i++){
            $param = [
                'name' => '店舗代表者' . $i,
                'email' => 'owner' . $i . '@test.jp',
                'password' => Hash::make('password' . $i),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            DB::table('owners')->insert($param);
        }
    }
}
