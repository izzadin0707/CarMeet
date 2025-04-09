<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Banned;
use App\Models\Categories;
use App\Models\Comments;
use App\Models\Creations;
use App\Models\Likes;
use App\Models\Saves;
use App\Models\Users;
use App\Models\Event;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreationsController extends Controller
{
    public function validateBan(){
        if(Banned::where('user_id', Auth::id())->first() == null){
            return true;
        }else{
            Auth::logout();
            return redirect('/')->withErrors(['email' => 'You Account Status Is Banned!']);
        }
    }

    public function index(Request $request, $category = 'general') {
        if($this->validateBan()){
            $page = 'general';
            $search = $request->query('search');
            $creation = Creations::with(['users', 'categorys']);
            
            if ($category) {
                $categoryModel = Categories::where('slug', $category)->firstOrFail();
                $page = $category;
                $creation = $creation->where('category_id', $categoryModel->id);
            }

            if ($request->has('search')) {
                $page = 'explore';
                $creation = $creation->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('desc', 'LIKE', '%' . $search . '%');
                });
            }


            return view('home', [
                "page" => $page,
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "assets" => Assets::all(),
                "user" => Auth::user(),
                "eventsAll" => Event::all(),
                "creations" => $creation->latest()->get(),
                "likes" => Likes::all(),
                "saves" => Saves::all(),
                "comments" => Comments::all(),
                "search" => $search,
            ]);
        }
    }

    public function detail($category, $id) {
        if($this->validateBan()){
            $page = $category == 'general' ? '' : $category;
            if (Creations::where('id', $id) != null) {
                $creation = Creations::with(['users', 'categorys']);

                return view('post-detail', [
                    "page" => $page,
                    "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                    "assets" => Assets::all(),
                    "user" => Auth::user(),
                    "eventsAll" => Event::all(),
                    "creation" => $creation->where('id', $id)->first(),
                    "comments" => Comments::with(['users'])->where('creation_id', $id)->latest()->get(),
                    "likes" => Likes::all(),
                    "saves" => Saves::all(),
                ]);
            } else {
                abort(404);
            }
        }
    }

    public function post(Creations $creation) {
        if($this->validateBan()){
            return view('post', [
                "color" => Auth::user()->color,
                "font" => Auth::user()->font,
                "creations" => Creations::with(['users', 'categorys'])->where('id', $creation->id)->latest()->get(),
                "saves" => Saves::all(),
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "user" => Auth::user(),
                "likes" => Likes::all()
            ]);
        }
    }

    public function allPost() {
        if($this->validateBan()){
            return view('post', [
                "color" => Auth::user()->color,
                "font" => Auth::user()->font,
                "creations" => Creations::with(['users', 'categorys'])->latest()->get(),
                "saves" => Saves::all(),
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "user" => Auth::user(),
                "likes" => Likes::all()
            ]);
        }
    }

    public function category(Categories $category) {
        if($this->validateBan()){
            if($category->slug == 'art'){
                return view('post', [
                    "color" => Auth::user()->color,
                    "font" => Auth::user()->font,
                    "creations" => Creations::with(['users'])->where('category_id', $category->id)->latest()->get(),
                    "saves" => Saves::all(),
                    "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                    "category" => $category->slug,
                    "user" => Auth::user(),
                    "likes" => Likes::all()
                ]);
            }elseif($category->slug == 'animation'){
                return view('post', [
                    "color" => Auth::user()->color,
                    "font" => Auth::user()->font,
                    "creations" => Creations::with(['users'])->where('category_id', $category->id)->latest()->get(),
                    "saves" => Saves::all(),
                    "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                    "category" => $category->slug,
                    "user" => Auth::user(),
                    "likes" => Likes::all()
                ]);
            }elseif($category->slug == 'design'){
                return view('post', [
                    "color" => Auth::user()->color,
                    "font" => Auth::user()->font,
                    "creations" => Creations::with(['users'])->where('category_id', $category->id)->latest()->get(),
                    "saves" => Saves::all(),
                    "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                    "category" => $category->slug,
                    "user" => Auth::user(),
                    "likes" => Likes::all()
                ]);
            }elseif($category->slug == 'music'){
                return view('post', [
                    "color" => Auth::user()->color,
                    "font" => Auth::user()->font,
                    "creations" => Creations::with(['users'])->where('category_id', $category->id)->latest()->get(),
                    "saves" => Saves::all(),
                    "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                    "category" => $category->slug,
                    "user" => Auth::user(),
                    "likes" => Likes::all()
                ]);
            }
        }
    }

    public function showSave() {
        if($this->validateBan()){
            return view('save', [
                "color" => Auth::user()->color,
                "font" => Auth::user()->font,
                "creations" => Creations::with(['users', 'categorys'])->latest()->get(),
                "saves" => Saves::all(),
                "assets" => Assets::all(),
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "user" => Auth::user(),
            ]);
        }
    }

    public function showLike() {
        if($this->validateBan()){
            return view('like', [
                "color" => Auth::user()->color,
                "font" => Auth::user()->font,
                "creations" => Creations::with(['users', 'categorys'])->latest()->get(),
                "likes" => Likes::all(),
                "assets" => Assets::all(),
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "user" => Auth::user()
            ]);
        }
    }

    public function search(Request $request) {
        if($this->validateBan()){
            return view('post', [
                "color" => Auth::user()->color,
                "font" => Auth::user()->font,
                "creations" => Creations::with(['users', 'categorys'])->where('title', 'LIKE', '%'.$request->input('search').'%')->orWhere('desc', 'LIKE', '%'.$request->input('search').'%')->latest()->get(),
                "saves" => Saves::all(),
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "user" => Auth::user(),
                "likes" => Likes::all()
            ]);
        }
    }

    public function showComment(Request $request) {
        return view('layouts.comment', [
            "color" => Auth::user()->color,
            "font" => Auth::user()->font,
            'comments' => Comments::with(['users'])->where('creation_id', $request->input('creation_id'))->latest()->get(),
            'assets' => Assets::all()
        ]);
    }

    public function like(Request $request) {
        $user_id = $request->input('user_id');
        $creation_id = $request->input('creation_id');
        $creation_user_id = $request->input('creation_user_id');
        $res = [
            'result' => false
        ];

        $existingLike = Likes::where('user_id', $user_id)
                         ->where('creation_id', $creation_id)
                         ->where('creation_user_id', $creation_user_id)
                         ->first();
        if (!$existingLike) {
            $like = new Likes([
                'user_id' => $user_id,
                'creation_id' => $creation_id,
                'creation_user_id' => $creation_user_id
            ]);

            if ($like->save()) {
                $res['result'] = true;
            }
        }

        $res['like_counts'] = Likes::where('creation_id', $creation_id)->count();
        return response()->json($res);
    }

    public function dislike(Request $request) {
        $user_id = $request->input('user_id');
        $creation_id = $request->input('creation_id');
        $creation_user_id = $request->input('creation_user_id');
        $res = [
            'result' => false
        ];

        $existingLike = Likes::where('user_id', $user_id)
                         ->where('creation_id', $creation_id)
                         ->where('creation_user_id', $creation_user_id)
                         ->first();
        if ($existingLike) {
            if ($existingLike->delete()) {
                $res['result'] = true;
            }
        }

        $res['like_counts'] = Likes::where('creation_id', $creation_id)->count();
        return response()->json($res);
    }

    public function save(Request $request) {
        $user_id = $request->input('user_id');
        $creation_id = $request->input('creation_id');
        $res = [
            'result' => false
        ];

        $existingSave= Saves::where('user_id', $user_id)
                         ->where('creation_id', $creation_id)
                         ->first();
        if (!$existingSave) {
            $save = new Saves([
                'user_id' => $user_id,
                'creation_id' => $creation_id,
            ]);

            if ($save->save()) {
                $res['result'] = true;
            }
        }

        $res['save_counts'] = Saves::where('creation_id', $creation_id)->count();
        return response()->json($res);
    }

    public function unsave(Request $request) {
        $user_id = $request->input('user_id');
        $creation_id = $request->input('creation_id');
        $res = [
            'result' => false
        ];

        $existingSave = Saves::where('user_id', $user_id)
                         ->where('creation_id', $creation_id)
                         ->first();
        if ($existingSave) {
            if ($existingSave->delete()) {
                $res['result'] = true;
            }
        }

        $res['save_counts'] = Saves::where('creation_id', $creation_id)->count();
        return response()->json($res);
    }

    public function comment(Request $request) {
        $desc = $request->input('desc');
        $creation_id = $request->input('creation_id');

        $comment = new Comments([
            'user_id' => Auth::id(),
            'creation_id' => $creation_id,
            'desc' => $desc
        ]);

        if($comment->save()){
            return redirect()->back()->with('status', 'Comment added successfully.');
        }
        
        return redirect()->back()->with('status', 'Failed to add comment.');
    }

    public function removeComment(Request $request) {
        $comment_id = $request->input('comment_id');

        $existingComment = Comments::where('id', $comment_id)->where('user_id', Auth::id())->first();
        if ($existingComment) {
            if ($existingComment->delete()) {
                return redirect()->back()->with('status', 'Comment removed successfully.');
            } else {
                return redirect()->back()->with('status', 'Failed to remove comment.');
            }
        }
        return redirect()->back()->with('status', 'Failed to remove comment.');
    }
}
