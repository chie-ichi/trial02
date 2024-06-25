<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
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

                 if($count % 5 == 0 || $count % 5 == 1) {
                    $stars = rand(1, 5);
                    
                    switch($stars){
                        case 1:
                            $comment = "料理が来るのが遅く、味もいまいちでした。質の割に値段も高すぎでした。";
                            break;
                        case 2:
                            $comment = "味は普通でしたが、店員の態度が悪いのが気になりました。";
                            break;
                        case 3:
                            $comment = "普通に美味しかったです。気が向けばまた来ます。";
                            break;
                        case 4:
                            $comment = "とても美味しかったです。少しだけ高かったので星4つ。";
                            break;
                        default:
                            $comment = "店の雰囲気も料理の味も素晴らしく、値段もリーズナブルで最高でした！！絶対リピートします。";
                            break;
                        }

                    $param = [
                        'user_id' => $i,
                        'restaurant_id' => $j,
                        'stars' => $stars,
                        'comment' => $comment,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    DB::table('reviews')->insert($param);
                }
                $count++;
            }
        }
    }
}
