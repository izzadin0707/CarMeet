<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Creations;
use App\Models\Likes;
use App\Models\Users;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(){
        $id = Auth::id();
        return view('profile', [
            "user" => Auth::user(),
            "color" => Auth::user()->color,
            "font" => Auth::user()->font,
            "creations" => Creations::with(['categorys'])->where('user_id', $id)->latest()->get(),
            "posts" => Creations::where('user_id', $id)->count(),
            "auth_assets" => Assets::where('user_id', $id)->get(),
            "assets" => Assets::where('user_id', $id)->get(),
            "likes" => Likes::where('creation_user_id', $id)->count()
        ]);
    }

    public function profile($username){
        if($username != Auth::user()->username){
            $user = Users::where('username', $username)->firstOrFail();
            $posts = Creations::where('user_id', $user->id)->count();
            $likes = Likes::where('creation_user_id', $user->id)->count();
            return view('profile', [
                "user" => $user,
                "color" => $user->color,
                "font" => $user->font,
                "creations" => Creations::with(['categorys'])->where('user_id', $user->id)->latest()->get(),
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "assets" => Assets::where('user_id', $user->id)->get(),
                "posts" => $posts,
                "likes" => $likes
            ]);
        }else{
            return redirect()->to('profile');
        }
    }

    public function profileSetting(){
        return view('profile-setting', [
            "user" => Auth::user(),
            "color" => Auth::user()->color,
            "font" => Auth::user()->font,
            "auth_assets" => Assets::where('user_id', Auth::id())->get()
        ]);
    }

    public function photoProfile(Request $request) {
        if($request->hasFile('photo-profile')){
            $file = $request->file('photo-profile');
            $mimeType = $file->getMimeType();
            $photoProfile = date('Ymd') . '0' . Auth::id();

            if (Str::startsWith($mimeType, 'image')) {
                $photoProfileEdit = Users::photoProfile($photoProfile);
                $file->storeAs('assets', $photoProfileEdit.'.png','public');
                return $photoProfileEdit;
            }
            return false;
                
        }
        return false;
    }

    public function banner(Request $request) {
        if($request->hasFile('banner-file-input')){
            $file = $request->file('banner-file-input');
            $mimeType = $file->getMimeType();
            $banner = date('Ymd') . '0' . Auth::id();

            if (Str::startsWith($mimeType, 'image')) {
                $bannerEdit = Users::banner($banner);
                $file->storeAs('assets', $bannerEdit.'.png','public');
                return $bannerEdit;
            }
            return false;
                
        }
        return false;
    }

    public function changeName(Request $request) {
        if($request->input('name')){
            $name = $request->input('name');
            $id = Auth::id();
            $username = $name . "#" . str_pad($id, 4, '0', STR_PAD_LEFT);
            
            Users::where('id', $id)->update(['name' => $name, 'username' => $username]);

            return true;
        }
        return false;
    }

    public function backgroundColor(Request $request) {
        if($request->input('color')){
            $color = $request->input('color');
            $id = Auth::id();
            
            Users::where('id', $id)->update(['color' => $color]);

            return true;
        }
        return false;
    }

    public function fontColor(Request $request) {
        if($request->input('color')){
            $color = $request->input('color');
            $id = Auth::id();
            
            Users::where('id', $id)->update(['font' => $color]);

            return true;
        }
        return false;
    }

    public function changePassword(Request $request) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
            ]);

            if(!Hash::check($request->old_password, auth()->user()->password)){
                return false;
            }

            Users::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return true;
    }

    public function resetTheme(Request $request) {
        $id = Auth::id();
        if(Users::where('id', $id)->update(['color' => null, 'font' => null])){
            return true;
        }else{
            return false;
        }
    }
}
