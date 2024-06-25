<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // リダイレクトの対象となるルート名を定義
    private const PREV_REDIRECT_ROUTE_NAMES = ['detail'];

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        try {
            //ユーザー情報を登録
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $user->sendEmailVerificationNotification();

            return redirect('/login')->with('flashSuccess', '会員登録が完了しました');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect('/register')->with('flashError', '会員登録時にエラーが発生しました: ' . $errorMessage);
        }
    }

    public function getLogin()
    {
        //前回保存した直前ページURLをセッションから削除
        session()->forget('url.intended');
        //直前ページのURLを取得
        $prev_url = url()->previous();
        //$prevUrlを元に直前ページのルート名を取得
        $prev_route_name = app('router')->getRoutes()->match(app('request')->create($prev_url))->getName();
        if(in_array($prev_route_name, self::PREV_REDIRECT_ROUTE_NAMES, true)) {
            //直前ページがリダイレクト対象URLの場合は、直前ページURLをセッションに保存
            session(['url.intended' => $prev_url]);
        }
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request['email'], 
            'password' => $request['password']
            ])) {
            //セッションに直前ページURLが保存されている場合は直前ページにリダイレクト、それ以外はトップページにリダイレクト
            return redirect()->intended('/');
        } else {
            return redirect('/login')->with('flashError', 'メールアドレスまたはパスワードが間違っています');
        }
    }

    public function logout(Request $request)
    { 
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('flashSuccess', 'ログアウトしました');
    }
}
