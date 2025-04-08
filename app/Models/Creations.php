<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Creations extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users() {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }

    public function categorys() {
        return $this->belongsTo('App\Models\Categories', 'category_id');
    }

    public static function createCreation($title, $desc, $creation, $type_file, $category_id, $user_id) {
        $newCreation = new Creations([
            'user_id' => $user_id,
            'category_id' => $category_id,
            'title' => $title,
            'desc' => $desc,
            'creation' => $creation,
            'type_file' => $type_file,
            'likes' => '0',
            'comments' => '0'
        ]);

        $newCreation->save();

        $creationEdit = null;
        if (!empty($creation)) {
            $creationId = $newCreation->id;
    
            $creationToUpdate = Creations::find($creationId);
    
            $creation = $newCreation->creation;
    
            $creationEdit = $creation . '0' . $creationId;
    
            $creationToUpdate->creation = $creationEdit;     
    
            $creationToUpdate->save();
        }


        return $creationEdit;
    }

    public static function updateCreation($title, $desc, $category_id, $id) {

        $creationToUpdate = Creations::find($id);

        $creationToUpdate->title = $title;
        $creationToUpdate->desc = $desc;
        $creationToUpdate->category_id = $category_id;

        if($creationToUpdate->save()){
            return true;
        }else{
            return false;
        }

    }

}
