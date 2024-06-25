<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage(Request $request)
    {
        $user = $request->user();
        $favorites = $user->favorite()->with('restaurant')->get();
        //予約情報を日付の新しい順にソートして取得
        $reservations = $user->reservation()->get()->sortByDesc(function ($reservation) {
            return $reservation->date . ' ' . $reservation->time;
        });

        return view('mypage', compact('favorites', 'reservations'));
    }
}
