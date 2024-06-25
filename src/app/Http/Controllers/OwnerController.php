<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Owner;
use App\Models\Area;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;

class OwnerController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        $categories = Category::all();
        $owner = Auth::guard('owners')->user();
        return view('owner.index', compact('areas', 'categories', 'owner'));
    }

    public function getLogin(Request $request)
    {
        return view('owner.login');
    }

    public function postRegister(RegisterRequest $request)
    {
        try {
            //店舗管理者情報を登録
            Owner::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            return redirect('/admin')->with('flashSuccess', '店舗管理者登録が完了しました');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect('/admin')->with('flashError', '店舗管理者登録時にエラーが発生しました: ' . $errorMessage);
        }
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::guard('owners')->attempt([
                'email' => $request['email'], 
                'password' => $request['password'],
            ])) {
            return redirect('/owner')->with('flashSuccess', 'ログインしました');
        } else {
            return redirect('/owner/login')->with('flashError', 'IDまたはパスワードが間違っています');
        }
    }

    public function logout(Request $request)
    { 
        Auth::guard('owners')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/owner/login')->with('flashSuccess', 'ログアウトしました');
    }

    public function message(Request $request)
    {
        $restaurant = Restaurant::find($request->restaurant_id);
        $user = User::find($request->user_id);
        return view('message', compact('restaurant', 'user'));
    }

    public function sendMessage(MessageRequest $request)
    {
        try{
            $restaurant = Restaurant::find($request->restaurant_id);
            $owner = $restaurant->getOwner();
            $from_mail = $owner->email;
            $from_name = $restaurant->name;

            $user = User::find($request->user_id);
            $to_mail = $user->email;
            $to_name = $user->name . '様';

            Mail::raw($request->body, function ($message) use ($request, $from_mail, $to_mail, $from_name, $to_name) {
                $message->from($from_mail, $from_name)
                        ->to($to_mail, $to_name)
                        ->subject($request->subject);
            });
            return redirect()->back()->with('flashSuccess', 'メールを送信しました');
        } catch (\Throwable $th) {
            return redirect()->back()->with('flashError', 'メール送信に失敗しました');
        }
    }
}
