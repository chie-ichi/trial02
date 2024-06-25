<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Owner;

class AdministratorController extends Controller
{
    public function index()
    {
        $owners = Owner::all();
        return view('admin.index', compact('owners'));
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        if (Auth::guard('administrators')->attempt([
                'userid' => $request['userid'], 
                'password' => $request['password'],
            ])) {
            return redirect('/admin')->with('flashSuccess', 'ログインしました');
        } else {
            return redirect('/admin/login')->with('flashError', 'IDまたはパスワードが間違っています');
        }
    }

    public function logout(Request $request)
    { 
        Auth::guard('administrators')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('flashSuccess', 'ログアウトしました');
    }
}
