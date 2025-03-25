<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }

    public static function createCreation($user_id, $title, $desc, $asset, $start_date, $end_date) {
        $newEvent = new Event([
            'user_id' => $user_id,
            'title' => $title,
            'desc' => $desc,
            'asset' => $asset,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $newEvent->save();

        $eventId = $newEvent->id;

        $eventToUpdate = Event::find($eventId);

        $asset = $newEvent->asset;

        $eventEdit = $asset . '0' . $eventId;

        $eventToUpdate->asset = $eventEdit;     

        $eventToUpdate->save();

        return $eventEdit;
    }

    public static function updateCreation($id, $title, $desc, $start_date, $end_date) {

        $eventToUpdate = Event::find($id);

        $eventToUpdate->title = $title;
        $eventToUpdate->desc = $desc;
        $eventToUpdate->start_date = $start_date;
        $eventToUpdate->end_date = $end_date;

        if($eventToUpdate->save()){
            return true;
        }else{
            return false;
        }

    }

    public static function banner($asset) {
        $banner = Assets::where('user_id', Auth::id())->where('status', 'event_banner')->first();
        if($banner){
            Storage::delete('events/'.$banner->asset.'.png');

            $assetId = $banner->id;

            $assetEdit = $asset . '0' . $assetId;

            Assets::where('id', $assetId)->update(['asset' => $assetEdit]);

            return $assetEdit;
        }else{
            $newAsset = new Assets([
                'user_id' => Auth::id(),
                'asset' => $asset,
                'status' => 'event_banner'
            ]);

            $newAsset->save();

            $assetId = $newAsset->id;

            $assetToUpdate = Assets::find($assetId);

            $assetNew = $newAsset->asset;

            $assetEdit = $assetNew . '0' . $assetId;

            $assetToUpdate->asset = $assetEdit;     

            $assetToUpdate->save();

            return $assetEdit;
        }
    }
}
