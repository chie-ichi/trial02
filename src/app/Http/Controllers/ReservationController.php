<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use App\Http\Requests\ReservationRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reservation(ReservationRequest $request)
    {
        //dateをフォーマット
        $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

        try {
            //予約情報を保存
            $reservation = Reservation::create([
                'user_id' => $request->user_id, //ユーザーID
                'restaurant_id' => $request->restaurant_id, //レストランID
                'date' => $date, //日付
                'time' => $request->time, //時間
                'number' => $request->number, //人数
            ]);

            if($reservation) {

                $reservation_id = $reservation->id;
                $url = config('app.url') . "/confirm-visit/{$reservation_id}";

                //QRコード画像を生成
                $qr_code = QrCode::format('png')->size(200)->generate($url);
                $base64_qr_code = base64_encode($qr_code);

                //ユーザーへ予約完了メール
                $restaurant = Restaurant::find($request->restaurant_id);
                $owner = $restaurant->getOwner();
                $from_mail = $owner->email;
                $from_name = $restaurant->name;

                $user = User::find($request->user_id);
                $to_mail = $user->email;
                $to_name = $user->name . '様';

                $body_html = "<p>{$to_name}</p>";
                $body_html .= "<p>この度は、{$from_name}にご予約いただき誠にありがとうございます。</p>";
                $body_html .= "<p>{$to_name}のご予約内容は以下のとおりです。</p>";
                $body_html .= "<p>-------------------------------------</p>";
                $body_html .= "<p>店名：{$from_name}<br>";
                $body_html .= "日時：{$reservation->date}　{$reservation->time}<br>";
                $body_html .= "人数：{$reservation->number}名様</p>";
                $body_html .= "<p>-------------------------------------</p>";
                $body_html .= "<p>※お支払いには、現金・クレジットカード・電子マネーのいずれかをご利用いただけます。</p>";
                $body_html .= "<p>※ご予約情報の確認のため、ご来店時に下記のQRコードをスタッフにお見せください。<br>";
                $body_html .= "<img src='data:image/png;base64," . $base64_qr_code . "' alt='QRコード'></p>";
                $body_html .= "<p>スタッフ一同、{$to_name}のご来店をお待ちしております。</p>";
                $body_html .= "<p>-------------------------------------</p>";
                $body_html .= "<p>{$from_name} &lt;{$from_mail}&gt;</p>";

                Mail::send([], [], function ($message) use ($from_mail, $to_mail, $from_name, $to_name, $body_html) {
                    $message->from($from_mail, $from_name)
                            ->to($to_mail, $to_name)
                            ->subject('【' . $from_name . '】予約が完了しました')
                            ->setBody($body_html, 'text/html');
                });
            }

            return redirect('/done'); //予約完了画面にリダイレクト
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect('/mypage')->with('flashError', '予約時にエラーが発生しました: ' . $errorMessage);
        }
    }

    public function done()
    {
        return view('done');
    }

    public function cancel(Request $request)
    {
        $id = $request->id;
        try {
            Reservation::where('id', $id)->delete();
            return redirect('/mypage')->with('flashSuccess', '予約を削除しました'); 
        } catch (\Throwable $th) {
            return redirect('/mypage')->with('flashError', '予約削除時にエラーが発生しました');
        }
    }

    public function edit(ReservationRequest $request)
    {
        //dateをフォーマット
        $date = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

        try {
            //予約情報を更新
            Reservation::find($request->id)->update([
                'date' => $date, //日付
                'time' => $request->time, //時間
                'number' => $request->number, //人数
            ]);
            return redirect('/mypage')->with('flashSuccess', '予約を更新しました');
        } catch (\Throwable $th) {
            return redirect('/mypage')->with('flashError', '予約更新時にエラーが発生しました');
        }
    }

    public function confirmVisit($reservation_id)
    {
        //予約情報を取得
        $reservation = Reservation::find($reservation_id);

        //予約情報の飲食店の代表者情報を取得
        $restaurant = Restaurant::find($reservation->restaurant_id);
        $restaurant_owner = $restaurant->getOwner();

        //ログイン中の代表者情報を取得
        $owner = Auth::guard('owners')->user();

        //予約の飲食店の代表者とログイン中の代表者が一致した場合のみ、来店確認および来店日時の記録を行う
        if($restaurant_owner->id == $owner->id) {
            $confirmed = true;
            $reservation->update([
                'visit_confirmation_at' => Carbon::now(), 
            ]);
        } else {
            $confirmed = false;
        }

        return view('confirm-visit', compact('reservation', 'confirmed'));
    }
}
