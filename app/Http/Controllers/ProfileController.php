<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Banned;
use App\Models\Comments;
use App\Models\Creations;
use App\Models\Event;
use App\Models\Likes;
use App\Models\Report;
use App\Models\Saves;
use App\Models\Users;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function validateBan(){
        $existingBan = Banned::where('user_id', Auth::id())->first();
        if($existingBan){
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Your Account Status Is Banned!']);
        }
        return true;
    }
    
    public function index($username = null, $tab = null){
        if($this->validateBan()){
            if ($username === null) {
                return redirect()->route('profile', ['username' => urlencode(Auth::user()->username), 'tab' => $tab]);
            }

            $page = $tab == null ? 'posting' : $tab;
            
            // Use authenticated user if username is null
            $profileUser = $username 
                ? Users::where('username', $username)->firstOrFail()
                : Auth::user();
            
            // Get creations for specific user
            $creation = Creations::with(['users', 'categorys'])
                ->where('user_id', $profileUser->id);
    
            return view('profile', [
                "page" => $page,
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "assets" => Assets::all(),
                "user" => $profileUser,
                "user_assets" => Assets::where('user_id', $profileUser->id)->get(),
                "eventsAll" => Event::all(),
                "reportAll" => Report::where('read', 0)->count(),
                "creations" => $creation->latest()->get(),
                "likes" => Likes::all(),
                "saves" => Saves::all(),
                "comments" => Comments::with('creations.categorys')->latest()->get(),
                "banned" => Banned::where('user_id', $profileUser->id)->first(),
            ]);
        }
        return redirect('/')->withErrors(['email' => 'You Account Status Is Banned!']);
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

    public function profileUpdate(Request $request) {
        $user = Auth::user();
        $updated = false;
    
        // Validate email and username
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255'
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Email already exists',
            'username.required' => 'Username is required',
            'username.max' => 'Username cannot exceed 255 characters'
        ]);
    
        // Handle photo profile upload
        if ($request->hasFile('photo-profile')) {
            $file = $request->file('photo-profile');
            $mimeType = $file->getMimeType();
            $photoProfile = date('Ymd') . '0' . $user->id;
    
            if (Str::startsWith($mimeType, 'image')) {
                $photoProfileEdit = Users::photoProfile($photoProfile);
                $file->move(public_path('storage/assets'), $photoProfileEdit.'.png');
                $updated = true;
            }
        }
    
        // Handle banner upload
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $mimeType = $file->getMimeType();
            $banner = date('Ymd') . '0' . $user->id;
    
            if (Str::startsWith($mimeType, 'image')) {
                $bannerEdit = Users::banner($banner);
                $file->move(public_path('storage/assets'), $bannerEdit.'.png');
                $updated = true;
            }
        }
    
        // Handle name and email update
        if ($request->filled('username') || $request->filled('email')) {
            $name = $request->input('username');
            $email = $request->input('email');
            $username = str_replace(' ', '_', $name) . "#" . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            
            Users::where('id', $user->id)->update([
                'name' => $name, 
                'username' => $username,
                'email' => $email
            ]);
            $updated = true;
        }
    
        if ($updated) {
            return redirect()->route('profile')->with('status', 'Profile updated successfully!');
        }
    
        return redirect()->back()->with('error', 'No changes were made.');
    }

    public function changePassword(Request $request) {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|string|min:8|',
            'password_confirmation' => 'required|string|min:8|same:new_password',
        ], [
            'password.required' => 'Password wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok.'
        ]);

        
        if(!Hash::check($request->password, auth()->user()->password)){
            return redirect()->back()->with('status', 'Password Wrong!');
        }

        Users::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('status', 'success change password!');
    }
}
