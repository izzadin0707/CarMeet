<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Creations;
use App\Models\Event;
use App\Models\Likes;
use App\Models\Report;
use App\Models\Saves;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request) {
        $search = $request->query('search');
        return view('event', [
            "page" => "event",
            "auth_assets" => Assets::where('user_id', Auth::id())->get(),
            "assets" => Assets::all(),
            "user" => Auth::user(),
            "eventsAll" => Event::latest()->get()->take(6),
            "reportAll" => Report::where('read', 0)->count(),
            "events" => Event::with('user')->where('title', 'LIKE', '%'.$search.'%')->latest()->get(),
            "likes" => Likes::all(),
            "saves" => Saves::all(),
            "search" => $search,
        ]);
    }

    public function detail($id) {
        if(Event::where('id', $id)->first() !== null){
            return view('event-detail', [
                "page" => "event",
                "auth_assets" => Assets::where('user_id', Auth::id())->get(),
                "assets" => Assets::all(),
                "user" => Auth::user(),
                "eventsAll" => Event::all(),
                "reportAll" => Report::where('read', 0)->count(),
                "event" => Event::with('user')->where('id', $id)->first(),
            ]);
        } else {
            abort(404);
        }
    }

    public function form($id = null) {
        if ($id) {
            if(Event::where('id', $id)->first() !== null){
                $event = Event::where('id', $id)->first();
                return view('event-form', [
                    "page" => 'event',
                    "assets" => Assets::all(),
                    "user" => Auth::user(),
                    "eventsAll" => Event::all(),
                "reportAll" => Report::where('read', 0)->count(),
                    "event" => $event,
                    'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
                ]);
            }else{
                abort(404);
            }
        } else {
            return view('event-form', [
                "page" => 'event',
                "assets" => Assets::all(),
                "user" => Auth::user(),
                "eventsAll" => Event::all(),
                "reportAll" => Report::where('read', 0)->count(),
                'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            ]);
        }

    }
    
    public static function eventView($id = null) {
        if ($id == null) {
            return view('dashboard.event-view', [
                "url" => 'event',
                'reports' => Report::all(),
                'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
            ]);
        } else {
            if(Event::where('id', $id)->first() !== null){
                $event = Event::where('id', $id)->first();
                return view('dashboard.event-view', [
                    "url" => 'event',
                    'reports' => Report::all(),
                    "event" => $event,
                    "assets" => Assets::where('user_id', $event->id)->get(),
                    'auth_assets' => Assets::where('user_id', Auth::guard('admin')->id())->get(),
                ]);
            }else{
                abort(404);
            }
        }
    }

    public static function upload(Request $request) {
        $file = $request->file('file');
        $title = $request->input('title');
        $desc = $request->has('desc') ? $request->input('desc') : "";
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        
        if ($file && $title && $start_date && $end_date) {
            $mimeType = $file->getMimeType();
            $userId = Auth::id();
            $asset = date('Ymd') . '0' . $userId . '00';
            
            if (Str::startsWith($mimeType, 'image')) {
                $creationEdit = Event::createCreation($userId, $title, $desc, $asset, $start_date, $end_date);
                $file->move(public_path('storage/events'), $creationEdit.'.png');
                // return redirect('/dashboard/events');
                return redirect()->back()->with('status', 'success upload event!');
            } else {
                return redirect()->back()->with('status', 'Failed to upload the file.');
            }
        }
        return redirect()->back()->with('status', 'No file uploaded.');
    }

    public static function update(Request $request) {
        $id = $request->input('id'); // ID event yang akan diupdate
        $file = $request->file('file');
        $title = $request->input('title');
        $desc = $request->has('desc') ? $request->input('desc') : "";
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        if ($title && $start_date && $end_date) {    
            // Update event
            if (Event::updateCreation($id, $title, $desc, $start_date, $end_date)) {
                if ($file) {
                    $mimeType = $file->getMimeType();
                    $event = Event::where('id', $id)->first();
                    $asset = $event->asset;
                    if (Str::startsWith($mimeType, 'image')) {
                        // Mengganti file lama jika ada
                        $existingFile = public_path('storage/events/' . $asset . '.png');
                        if (file_exists($existingFile)) {
                            unlink($existingFile); // Menghapus file lama
                        }
                        
                        // Menyimpan file baru
                        $file->move(public_path('storage/events'), $asset . '.png');
                        return redirect()->back()->with('status', 'Success update event!');
                        // return redirect('/dashboard/events')->with('status', 'Event updated successfully.');
                    } else {
                        return redirect()->back()->with('status', 'Failed to upload the file. Only image files are allowed.');
                    }
                } else {
                    return redirect()->back()->with('status', 'Success update event!');
                    // return redirect('/dashboard/events')->with('status', 'Event updated successfully.');
                }
            } else {
                return redirect()->back()->with('status', 'Failed to update event.');
            }
        }
        return redirect()->back()->with('status', 'Please fill in all required fields.');
    }    

    public static function delete($id) {
        // Temukan event berdasarkan ID
        $event = Event::where('id', $id)->first();
    
        // Jika event ditemukan
        if ($event) {
            // Menghapus file yang terkait dengan event jika ada
            $existingFile = public_path('storage/events/' . $event->asset . '.png');
            if (file_exists($existingFile)) {
                unlink($existingFile); // Menghapus file
            }
    
            // Menghapus event dari database
            if ($event->delete()) {
                // return redirect('/dashboard/events')->with('status', 'Event deleted successfully.');
                return redirect()->route('event')->with('status', 'success upload event!');
            } else {
                return redirect()->back()->with('status', 'Failed to delete event.');
            }
        } else {
            return redirect()->back()->with('status', 'Event not found.');
        }
    }
    
}
