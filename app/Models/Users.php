<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class Users extends Model implements Authenticatable, MustVerifyEmail
{
    use MustVerifyEmailTrait;
    use AuthenticatableTrait;
    use Notifiable;
    use HasFactory;

    protected $guarded = ['id'];

    public function categories() {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public static function photoProfile($asset) {
        $photo_profile = Assets::where('user_id', Auth::id())->where('status', 'photo-profile')->first();
        if($photo_profile){
            Storage::delete('assets/'.$photo_profile->asset.'.png');

            $assetId = $photo_profile->id;

            $assetEdit = $asset . '0' . $assetId;

            Assets::where('id', $assetId)->update(['asset' => $assetEdit]);

            return $assetEdit;
        }else{
            $newAsset = new Assets([
                'user_id' => Auth::id(),
                'asset' => $asset,
                'status' => 'photo-profile'
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

    public static function banner($asset) {
        $banner = Assets::where('user_id', Auth::id())->where('status', 'banner')->first();
        if($banner){
            Storage::delete('assets/'.$banner->asset.'.png');

            $assetId = $banner->id;

            $assetEdit = $asset . '0' . $assetId;

            Assets::where('id', $assetId)->update(['asset' => $assetEdit]);

            return $assetEdit;
        }else{
            $newAsset = new Assets([
                'user_id' => Auth::id(),
                'asset' => $asset,
                'status' => 'banner'
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
