<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function creation() {
        return $this->belongsTo(Creations::class, 'creation_id');
    }

    public function comment() {
        return $this->belongsTo(Comments::class, 'comment_id');
    }

    public function profile() {
        return $this->belongsTo(Users::class, 'profile_id');
    }
}
