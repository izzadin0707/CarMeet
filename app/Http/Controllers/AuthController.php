<?php

namespace App\Http\Controllers;

use App\Models\Banned;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public static function index(){
        return view('auth.index', [
            'categories' => Categories::all(),
            'showRegister' => false // Tambahkan variabel untuk mengontrol tampilan form
        ]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
            'password.required' => 'Password wajib diisi.'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $remember = $request->has('remember');

        $user = Users::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->with('error', 'Email atau password salah!')
                ->withInput();
        }

        $banned = Banned::where('user_id', $user->id)->first();
        if($banned != null){
            $banDate = $banned->banned;
            $today = time();
            if(strtotime($banDate) <= $today){
                $banned->delete();
                Auth::login($user, $remember);
                return redirect()->intended('/');
            }else{
                $difference = strtotime($banDate) - $today;
                $days = ceil($difference / (60 * 60 * 24));
                return back()
                    ->with('error', "Akun Anda dibanned. Sisa waktu $days hari.")
                    ->withInput();
            }
        }

        Auth::login($user, $remember);
        return redirect()->intended('/');
    }

    public function logout() {
        Auth::logout();
        Auth::guard('admin')->logout();

        return redirect('/auth');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Username wajib diisi.',
            'name.max' => 'Username maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('showRegister', true); // Tambahkan session untuk menampilkan register form
        }

        $user = new Users([
            'name' => $request->name,
            'email' => $request->email,
            'username' => '',
            'password' => Hash::make($request->password),
            'roles' => 0
        ]);

        $user->save();

        $userId = $user->id;

        $userUpdate = Users::find($userId);

        $userUpdate->username = $request->name . "#" . str_pad($userId, 4, '0', STR_PAD_LEFT);

        if($userUpdate->save()) {
            return redirect('/auth')->with('success', 'Registrasi berhasil! Silakan login.');
        } else {
            $user->delete();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan, tolong periksa koneksi anda')
                ->with('showRegister', true); // Tambahkan session untuk menampilkan register form
        }
    }
}