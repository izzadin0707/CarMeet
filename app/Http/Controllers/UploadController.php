<?php

namespace App\Http\Controllers;

use App\Models\Creations;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assets;
use App\Models\Categories;
use App\Models\Comments;
use App\Models\Likes;
use App\Models\Report;
use App\Models\Saves;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public static function index() {
        return view('upload', [
            'categories' => Categories::all(),
            "auth_assets" => Assets::where('user_id', Auth::id())->get()
        ]);
    }

    public static function edit(Creations $creation) {
        return view('update', [
            "creations" => Creations::with(['users', 'categorys'])->where('id', $creation->id)->latest()->get(),
            'categories' => Categories::all(),
            "user" => Auth::user(),
            "auth_assets" => Assets::where('user_id', Auth::id())->get()
        ]);
    }

    public function remove(Creations $creation) {
        return view('remove', [
            "creations" => Creations::with(['users', 'categorys'])->where('id', $creation->id)->latest()->get(),
            "user" => Auth::user(),
            "auth_assets" => Assets::where('user_id', Auth::id())->get()
        ]);
    }

    public static function upload(Request $request) {
        $file = $request->file('file');
        $title = $request->input('title');
        $desc = $request->has('desc') ? $request->input('desc') : "";
        $category = $request->input('category');

    if ($file && $title && $category) {
        $mimeType = $file->getMimeType();
        $categories = Categories::all();
        foreach ($categories as $c){
            if($c->id == $category){

                $userId = Auth::id();
                $creation = date('Ymd') . '0' . $userId . '0' . $category;

                if (Str::startsWith($mimeType, 'image')) {
                    $creationEdit = Creations::createCreation($title, $desc, $creation, 'png', $category, $userId);
                    $file->move(public_path('storage/creations'), $creationEdit.'.png');
                    return redirect('/profile');
                }
                elseif (Str::startsWith($mimeType, 'video')) {
                    $creationEdit = Creations::createCreation($title, $desc, $creation, 'mp4', $category, $userId);
                    $file->move(public_path('storage/creations'), $creationEdit.'.mp4');
                    return redirect('/profile');
                }
                else {
                    return redirect()->back()->with('status', 'Failed to upload the file.');
                }

            }
        }
    }
        return redirect()->back()->with('status', 'No file uploaded.');
    }

    public static function update(Request $request) {
        $title = $request->input('title');
        $desc = $request->has('desc') ? $request->input('desc') : "";
        $category = $request->input('category');
        $creation = Creations::where('id', $request->input('creation'))->first();
        // dd($creation->id);

    if ($title && $category) {
        $categories = Categories::all();
        foreach ($categories as $c){
            if($c->id == $category){
                if(Creations::updateCreation($title, $desc, $category, $creation->id)){
                    return redirect('/profile');
                }else {
                    return redirect()->back()->with('status', 'Failed to update the post.');
                }
            }
        }
    }
        return redirect()->back()->with('status', 'No file update.');
    }

    public static function delete(Request $request) {
        $creation = Creations::where('id', $request->input('creation'))->first();
        if($creation){
            if(Storage::delete('public/creations/'.$creation->creation.'.'.$creation->type_file)){
                Saves::where('creation_id', $creation->id)->delete();
                Likes::where('creation_id', $creation->id)->delete();
                Comments::where('creation_id', $creation->id)->delete();
                Report::where('creation_id', $creation->id)->delete();
                $file = $creation->creation . $creation->type_file;
                if($creation->delete()){
                    return redirect('/profile')->with('message', 'Success Deleted Creation!');
                } else {
                    return redirect('/profile')->with('error', 'Failed Deleted Creation!');
                }
            } else {
                return redirect('/profile')->with('error', 'Creation Not Found!');
            }
        }
        return redirect('/profile')->with('error', 'Creation Not Found!');
    }
}
