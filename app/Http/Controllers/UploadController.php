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
        $title = $request->has('title') ? $request->input('title') : "";
        $desc = $request->has('desc') ? $request->input('desc') : "";
        $category = $request->has('category') ? $request->input('category') : '1';

        if ($request->has('category')) {
            $category = Categories::where('slug', $category)->firstOrFail()->id;
        }

        if ($file || $desc) {
            $userId = Auth::id();
            $creation = null;
            $type = null;
            if ($file) {
                $mimeType = $file->getMimeType();
                $creation = date('Ymd') . '0' . $userId . '0' . $category;

                if (Str::startsWith($mimeType, 'image')) $type = 'png';
                elseif (Str::startsWith($mimeType, 'video')) $type = 'mp4';
                else return redirect()->back()->with('status', 'Failed to upload the file.');
            }
            
            $creationEdit = Creations::createCreation($title, $desc, $creation, $type, $category, $userId);

            if ($file) $file->move(public_path('storage/creations'), $creationEdit.'.'.$type);
            return redirect()->back();
     
            // $categories = Categories::all();
            // foreach ($categories as $c){
            //     if($c->id == $category){

                    
            //     }
            // }

            // if (Str::startsWith($mimeType, 'image')) {
            //     $creationEdit = Creations::createCreation($title, $desc, $creation, 'png', $category, $userId);
            //     $file->move(public_path('storage/creations'), $creationEdit.'.png');
            //     return redirect()->back();
            //     // return redirect('/profile');
            // }
            // elseif (Str::startsWith($mimeType, 'video')) {
            //     $creationEdit = Creations::createCreation($title, $desc, $creation, 'mp4', $category, $userId);
            //     $file->move(public_path('storage/creations'), $creationEdit.'.mp4');
            //     return redirect()->back();
            //     // return redirect('/profile');
            // }
            // else {
            //     return redirect()->back()->with('status', 'Failed to upload the file.');
            // }
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

                $existingFile = public_path('storage/creations/' . $creation->creation . '.' . $creation->type_file);
                if (file_exists($existingFile)) {
                    unlink($existingFile); // Menghapus file
                }

                if($creation->delete()){
                     return redirect()->back()->with('message', 'Success Deleted Creation!');
                } else {
                     return redirect()->back()->with('error', 'Failed Deleted Creation!');
                }
            } else {
                 return redirect()->back()->with('error', 'Creation Not Found!');
            }
        }
        return redirect()->back()->with('error', 'Creation Not Found!');
    }
}
