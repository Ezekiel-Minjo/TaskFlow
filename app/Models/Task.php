<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'status', 'deadline'];
    public function user() {
        return $this->belongsTo(user::class);
    }
}
