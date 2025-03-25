<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \App\Mail\VerifyEmail;
use App\Models\Banned;

class AuthController extends Controller
{
    public static function index(){
        return view('auth.index', [
            'categories' => Categories::all()
        ]);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        
        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // if($field == 'username'){
        //     $credentials[$field] = $credentials['message'];
        //     unset($credentials['message']);
        // }

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $banned = Banned::where('user_id', Auth::id())->first();
            if($banned != null){
                $banDate = $banned->banned;
                $today = time();
                if(strtotime($banDate) <= $today){
                    $banned->delete();
                    return redirect()->intended('/');
                }else{
                    Auth::logout();
                    $difference = strtotime($banDate) - $today;
                    $days = ceil($difference / (60 * 60 * 24));
                    return back()->with(['message' => 'You Account Status Is Banned, '.$days.' Days Left.']);
                }
            }else{
                return redirect()->intended('/');
            }
        } else {
            return back()->with(['message' => 'Wrong Email or Password!']);
        }
    }

    public function logout() {
        Auth::logout();
        Auth::guard('admin')->logout();

        return redirect('/auth');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

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
            return redirect('/auth');
        }else{
            $user->delete();
            return redirect()->back()->with('message', 'Terjadi kesalahan, tolong periksa koneksi anda');
        }
    }

    // public function resend(Request $request) {
    //     $user = Users::where('email', $request->email)->first();

    //     if ($user) {
    //         Mail::to($request->email)->send(new VerifyEmail($user));
    //         return view('emails.resend_verify')->with('status', 'Verification email has been resent.')->with('email', $request->email);
    //     } else {
    //         return view('emails.resend_verify')->with('status', 'Failed to resend verification email.')->with('email', $request->email);
    //     }
    // }

}
