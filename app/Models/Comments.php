<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users() {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }

    public function creations() {
        return $this->belongsTo('App\Models\Creations', 'creation_id');
    }
}
