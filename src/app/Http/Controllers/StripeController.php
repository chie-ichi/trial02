<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;
use App\Models\Reservation;

class StripeController extends Controller
{
    public function charge(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET')); //シークレットキー

            Charge::create(array(
                'amount' => 100,
                'currency' => 'jpy',
                'source'=> request()->stripeToken,
            ));

            Reservation::find($request->reservation_id)->update([
                'paid_at' => Carbon::now(), 
            ]);

            return redirect()->back()->with('flashSuccess', 'お支払いが完了しました');
        } catch (\Throwable $th) {
            return redirect()->back()->with('flashError', 'お支払い時にエラーが発生しました');
        }
    }
}
