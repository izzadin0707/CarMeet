<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Banned;
use App\Models\Comments;
use App\Models\Creations;
use App\Models\Event;
use App\Models\Report;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginForm()
    {
        if ($this->validateAdmin()) {
            return view('dashboard.auth.login');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($field == 'username') {
            $credentials[$field] = $credentials['email'];
            unset($credentials['email']);
        }

        if (auth('admin')->attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            return back()->with(['email' => 'Wrong Email or Password!']);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard-login-form');
    }

    public function validateAdmin()
    {
        $user = Auth::user();
        if ($user->roles == 1) {
            return true;
        } else {
            abort(404);
        }
    }

    public function index()
    {
        return view('dashboard.home', [
            'url' => 'home',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'reports' => Report::all(),
            'users' => Users::all()->count(),
            'creations' => Creations::all()->count(),
            'comments' => Comments::all()->count()
        ]);
    }

    public function allUser()
    {
        return view('dashboard.users', [
            'url' => 'users',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'users' => Users::all(),
            'banned' => Banned::all(),
            'reports' => Report::all()
        ]);
    }

    public function allCreation()
    {
        return view('dashboard.creations', [
            'url' => 'creations',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'creations' => Creations::all(),
            'reports' => Report::all()
        ]);
    }

    public function allComment()
    {
        return view('dashboard.comments', [
            'url' => 'comments',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'comments' => Comments::all(),
            'reports' => Report::all()
        ]);
    }

    public function allReport()
    {
        return view('dashboard.reports', [
            'url' => 'reports',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'reports' => Report::with(['user'])->latest()->get()
        ]);
    }

    public function allEvent()
    {
        return view('dashboard.event', [
            'url' => 'event',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'event' => Event::with(['user'])->latest()->get(),
            'reports' => Report::all()
        ]);
    }

    public function changeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'roles' => 'required'
        ]);
        $user = Users::where('id', $request->input('user_id'))->first();
        $user->update(['roles' => $request->input('roles')]);
        return redirect()->back();
    }

    public function usersSearch(Request $request)
    {
        return view('dashboard.layouts.users-search', [
            'users' => Users::where('name', 'LIKE', $request->input('key') . '%')->get(),
            'banned' => Banned::all()
        ]);
    }

    public function creationsSearch(Request $request)
    {
        return view('dashboard.layouts.creations-search', [
            'creations' => Creations::where('title', 'LIKE', '%' . $request->input('key') . '%')->orWhere('desc', 'LIKE', '%' . $request->input('key') . '%')->get()
        ]);
    }

    public function commentsSearch(Request $request)
    {
        return view('dashboard.layouts.comments-search', [
            'comments' => Comments::where('desc', 'LIKE', '%' . $request->input('key') . '%')->get()
        ]);
    }

    public function reportsSearch(Request $request)
    {
        return view('dashboard.layouts.reports-search', [
            'reports' => Report::with(['user'])->where('desc', 'LIKE', '%' . $request->input('key') . '%')->get()
        ]);
    }

    public function eventSearch(Request $request)
    {
        return view('dashboard.layouts.event-search', [
            'event' => Event::where('title', 'LIKE', '%' . $request->input('key') . '%')->orWhere('desc', 'LIKE', '%' . $request->input('key') . '%')->get()
        ]);
    }
}
