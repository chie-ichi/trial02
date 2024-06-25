<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request)
    {
        $user_id = $request->user_id; //ユーザーのIDを取得
        $restaurant_id = $request->restaurant_id; //レストランのIDを取得
        
        //該当するお気に入り情報レコードが存在するか検索
        $favorites = Favorite::where('user_id', $user_id)
            ->where('restaurant_id', $restaurant_id)
            ->get();

        $is_success = false;

        if($favorites->isEmpty()) {
            //該当するレコードが存在しない場合、お気に入り情報レコードを作成

            try {
                Favorite::create([
                    'user_id' => $user_id,
                    'restaurant_id' => $restaurant_id,
                ]);
                $is_success = true;
            } catch (\Throwable $th) {
                $is_success = false;
            }
        }

        //呼び出し元ページにリダイレクト
        if($is_success){
            return redirect()->back()->with('flashSuccess', 'お気に入りを登録しました');
        } else {
            return redirect()->back()->with('flashError', 'お気に入りの登録に失敗しました');
        }
    }

    public function removeFavorite(Request $request)
    {
        $user_id = $request->user_id; //ユーザーのIDを取得
        $restaurant_id = $request->restaurant_id; //レストランのIDを取得
        
        //該当するお気に入り情報レコードが存在するか検索
        $favorites = Favorite::where('user_id', $user_id)
            ->where('restaurant_id', $restaurant_id)
            ->get();

        $is_success = false;

        if(!$favorites->isEmpty()) {
            //該当するレコードが存在する場合、そのレコードを削除
            foreach($favorites as $favorite) {
                try {
                    $favorite->delete();
                    if(!$is_success) {
                        $is_success = true;
                    }
                } catch (\Throwable $th) {
                    $is_success = false;
                }
            }
        }

        //呼び出し元ページにリダイレクト
        if($is_success){
            return redirect()->back()->with('flashSuccess', 'お気に入りを削除しました');
        } else {
            return redirect()->back()->with('flashError', 'お気に入りの削除に失敗しました');
        }
    }
}
