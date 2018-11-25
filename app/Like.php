<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function post() {
        $this->belongsTo('App\Post');
    }
}
