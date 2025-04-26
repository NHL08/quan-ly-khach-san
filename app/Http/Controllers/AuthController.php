<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Auth;
use Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function __construct() {
        @session_start();
    }

    public function getLogin() {
        return view('auth.login');
    }

    public function postLogin(Request $request) {
        if ($request->email == '' || $request->password == '') {
            return redirect('/login')->with('notice', 'Tài khoản hoặc mật khẩu không được để trống.');
        }

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $expirationTime = strtotime(auth()->user()->remember_token);
            $cookie = cookie('khachsan_website', 'cookie_value', $expirationTime);
            return redirect('/')->withCookie($cookie);
        } else {
            return redirect('/login')->with('notice', 'Tài khoản hoặc mật khẩu chưa chính xác, vui lòng thử lại.');
        }
    }

    public function getLogout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    public function getRegister() {
        return view('auth.register');
    }

    public function postRegister(Request $request) {
        if ($request->email == '' || $request->address == '' || $request->phone == '' || $request->firstname == '' || $request->lastname == '' || $request->password == ''|| $request->confirmpassword == '') {
            return redirect('/register')->with('notice', 'Vui lòng nhập vào các trường có đánh dấu *.');
        }

        $uppercase = preg_match('@[A-Z]@', $request->password);
        $lowercase = preg_match('@[a-z]@', $request->password);
        $number    = preg_match('@[0-9]@', $request->password);
        $specialChars = preg_match('@[^\w]@', $request->password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($request->password) < 8) {
            return redirect('/register')->withInput()->with('notice', 'Mật khẩu phải có độ dài ít nhất 8 ký tự và phải bao gồm ít nhất một chữ in hoa, một số và một ký tự đặc biệt.');
        }

        if($request->password != $request->confirmpassword) {
            return redirect('/register')->withInput()->with('notice', 'Nhập lại mật khẩu không chính xác.');
        }

        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        $User = new User;
        $User->email = $request->email;
        $User->fullname = $request->firstname . " " . $request->lastname;
        $User->address = $request->address;
        $User->phone = $request->phone;
        $User->password = bcrypt($request->password);
        $User->role = 1;
        $User->remember_token = Str::random(60);
        $User->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $User->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Flag = $User->save();

        if($Flag == true) {
            return redirect('/login');
        }
    }

    public function getForgot() {
        return view('auth.forgot');
    }
}
