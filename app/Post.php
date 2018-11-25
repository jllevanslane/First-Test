<?php

/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 11/16/2018
 * Time: 4:41 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    /*
     * A post may have many likes.
     */
    public function likes() {
        return $this->hasMany('App\Like');
    }

    /*
     * A post may belong to many tags.
     */
    public function tags() {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /*
     * A post belongs to a specific user.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}