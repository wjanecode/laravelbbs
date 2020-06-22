<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['post_id', 'user_id', 'content'];
}
