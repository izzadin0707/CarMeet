<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saves extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users() {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function creations() {
        return $this->belongsTo(Creations::class, 'creation_id');
    }
}
