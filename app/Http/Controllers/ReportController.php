<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Banned;
use App\Models\Comments;
use App\Models\Creations;
use App\Models\Likes;
use App\Models\Report;
use App\Models\Saves;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    
    public static function reportCreationView($creation) {
        return view('report-creation', [
            'creation' => Creations::with(['users'])->where('creation', $creation)->first(),
            'report' => 'creation',
            "auth_assets" => Assets::where('user_id', Auth::id())->get(),
        ]);
    }
    
    public static function reportCommentView($comment) {
        return view('report-comment', [
            'comment' => Comments::with(['users'])->where('id', $comment)->first(),
            'assets' => Assets::all(),
            'report' => 'comment',
            "auth_assets" => Assets::where('user_id', Auth::id())->get(),
        ]);
    }
    
    public static function reportProfileView($profile) {
        return view('report-profile', [
            'user' => Users::find($profile),
            'assets' => Assets::all(),
            'report' => 'profile',
            'auth_assets' => Assets::where('user_id', Auth::id())->get(),
        ]);
    }

    public static function reportCreation(Request $request) {
        $request->validate([
            'report_message' => 'required',
            'creation_id' => 'required'
        ]);

        $report = new Report([
            'user_id' => Auth::id(),
            'creation_id' => $request->creation_id,
            'desc' => $request->report_message,
            'read' => 0
        ]);

        if($report->save()){
            $creation = Creations::find($request->creation_id);
            return redirect('/post/'.$creation->creation);
        }else{
            return redirect()->back()->with('message', 'Failed to send Report!');
        }
    }

    public static function reportComment(Request $request) {
        $request->validate([
            'report_message' => 'required',
            'comment_id' => 'required',
        ]);

        $report = new Report([
            'user_id' => Auth::id(),
            'comment_id' => $request->comment_id,
            'desc' => $request->report_message,
            'read' => 0
        ]);

        if($report->save()){
            return "<script>window.history.go(-2);</script>";
        }else{
            return redirect()->back()->with('message', 'Failed to send Report!');
        }
    }

    public static function reportProfile(Request $request) {
        $request->validate([
            'report_message' => 'required',
            'profile_id' => 'required',
        ]);

        $report = new Report([
            'user_id' => Auth::id(),
            'profile_id' => $request->profile_id,
            'desc' => $request->report_message,
            'read' => 0
        ]);

        if($report->save()){
            return redirect('profile/'.str_replace('#', '%23', Users::find($request->profile_id)->username));
        }else{
            return redirect()->back()->with('message', 'Failed to send Report!');
        }
    }

    public static function reportRead($id) {
        $report = Report::with(['user'])->where('id', $id)->first();
        if($report->read === 0){
            $report->update(['read' => 1]);
        }
        return view('dashboard.report-read', [
            'url' => 'reports',
            'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            'reports' => Report::all(),
            'report' => Report::with(['user'])->where('id', $id)->first(),
        ]);
    }

    public static function reportDrop($id) {
        $report = Report::with(['user'])->where('id', $id)->first();
        if($report !== null){
            if($report->delete()){
                return back()->with('message', 'Success Drop Report!');
            }else{
                return back()->with('message', 'Failed Drop Report!');
            }
        }else{
            return back()->with('message', 'Report Not Found!');
        }
    }

    public static function usersView($id) {
        if(Users::where('id', $id)->first() !== null){
            $user = Users::where('id', $id)->first();
            $posts = Creations::where('user_id', $user->id)->count();
            $likes = Likes::where('creation_user_id', $user->id)->count();
            return view('dashboard.users-view', [
                "url" => 'users',
                'reports' => Report::all(),
                "user" => $user,
                "creations" => Creations::with(['categorys'])->where('user_id', $user->id)->latest()->get(),
                "assets" => Assets::where('user_id', $user->id)->get(),
                'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
                "posts" => $posts,
                "likes" => $likes,
                "banned" => Banned::where('user_id', $id)->first()
            ]);
        }else{
            abort(404);
        }
    }

    public static function creationsView($id) {
        if(Creations::with(['users'])->where('id', $id)->first() !== null){
            return view('dashboard.creations-view', [
                "url" => 'creations',
                'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
                'reports' => Report::all(),
                'creation' => Creations::with(['users'])->where('id', $id)->first(),
                'report' => 'creation',
            ]);
        }else{
            abort(404);
        }
    }

    public static function commentsView($id) {
        if(Comments::with(['users'])->where('id', $id)->first() !== null){
            return view('dashboard.comments-view', [
                "url" => 'comments',
                'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
                'reports' => Report::all(),
                'comment' => Comments::with(['users'])->where('id', $id)->first(),
                'assets' => Assets::all()
            ]);
        }else{
            abort(404);
        }
    }

    public static function bannedUser($id) {
        if(Users::where('id', $id)->firstOrFail()){
            if(Banned::where('user_id', $id)->first() == null){
                $today = date('Y-m-d');
                $next_week = date('Y-m-d', strtotime($today . ' + 7 days'));
    
                $banned = new Banned([
                    'user_id' => $id,
                    'banned' => $next_week
                ]);
                if($banned->save()) {
                    return redirect('/dashboard/users')->with('message', 'Success Ban User!');
                }else{
                    return redirect('/dashboard/users')->with('message', 'Failed Ban User!');
                }
            }else{
                return redirect('/dashboard/users')->with('message', 'User Does Banned!');
            }
        }else{
            abort(404);
        }
    }

    public static function unbannedUser($id) {
        $banned = Banned::find($id)->first();
        if($banned != null){
            if($banned->delete()){
                return redirect('/dashboard/users')->with('message', 'Success Unbanned User!');
            }else{
                return redirect('/dashboard/users')->with('message', 'Failed Unbanned User!');
            }
        }else{
            return redirect('/dashboard/users')->with('message', "User Doesn't Banned!");
        }
    }

    public static function deletedCreation($id) {
        $creation = Creations::where('id', $id)->first();
        if($creation){
            if(Storage::delete('creations/'.$creation->creation.'.'.$creation->type_file)){
                Saves::where('creation_id', $creation->id)->delete();
                Likes::where('creation_id', $creation->id)->delete();
                Comments::where('creation_id', $creation->id)->delete();
                if($creation->delete()){
                    return redirect('/dashboard/creations')->with('message', 'Success Deleted Creation!');
                } else {
                    return redirect('/dashboard/creations')->with('message', 'Failed Deleted Creation!');
                }
            } else {
                return redirect('/dashboard/creations')->with('message', 'Creation Not Found!');
            }
        }
        return redirect('/dashboard/creations')->with('message', 'Creation Not Found!');
    }

    public static function deletedComment($id) {
        $existingComment = Comments::where('id', $id)->first();
        if ($existingComment) {
            if ($existingComment->delete()) {
                return redirect('/dashboard/comments')->with('message', 'Success Deleted Comment!');
            } else {
                return redirect('/dashboard/comments')->with('message', 'Failed Deleted Comment!');
            }
        }
        return redirect('/dashboard/comments')->with('message', 'Comment Not Found!');
    }
}
