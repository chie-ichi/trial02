<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Restaurant;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function review(Request $request)
    {
        $user_id = $request->user_id;
        $restaurant = Restaurant::find($request->restaurant_id);
        return view('review', compact('user_id', 'restaurant'));
    }

    public function addReview(ReviewRequest $request)
    {
        try {
            Review::create([
                'user_id' => $request->user_id,
                'restaurant_id' => $request->restaurant_id,
                'stars' => $request->stars,
                'comment' => $request->comment,
            ]);
            return redirect('/mypage')->with('flashSuccess', 'レビューを投稿しました');
        } catch (\Throwable $th) {
            return redirect('/mypage')->with('flashError', 'レビューの投稿に失敗しました');
        }
    }
}
