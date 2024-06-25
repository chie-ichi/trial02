<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            $count = 0;
            for($j = ($i % 5) + 1; $j <= 20; $j+=5){

                $visit_confirmation_at = null;
                $random_number = rand(0, 1); //2値の乱数

                //日付と時間の設定
                switch($count % 5) {
                    case 0:
                        $date = Carbon::now()->subWeeks(4)->format('Y-m-d');
                        $time = '12:00:00';
                        if($random_number) {
                            $visit_confirmation_at = $date . ' ' . $time;
                        }
                        break;
                    case 1:
                        $date = Carbon::now()->subWeeks(2)->format('Y-m-d');
                        $time = '18:00:00';
                        if($random_number) {
                            $visit_confirmation_at = $date . ' ' . $time;
                        }
                        break;
                    case 2:
                        $date = Carbon::now()->format('Y-m-d');
                        $time = '16:00:00';
                        break;
                    case 3:
                        $date = Carbon::now()->addWeeks(2)->format('Y-m-d');
                        $time = '18:00:00';
                        break;
                    default:
                        $date = Carbon::now()->addMonth()->format('Y-m-d');
                        $time = '20:00:00';
                        break;
                }

                $param = [
                    'user_id' => $i,
                    'restaurant_id' => $j,
                    'date' => $date,
                    'time' => $time,
                    'number' => rand(1, 10),
                    'visit_confirmation_at' => $visit_confirmation_at,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                DB::table('reservations')->insert($param);
                $count++;
            }
        }
    }
}
