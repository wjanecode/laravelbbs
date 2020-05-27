<?php

namespace App\Models;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    /**
     * 一对一
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(  ) {
        return $this->belongsTo(User::class);
    }

    /**
     * 一对一
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(  ) {
        return $this->belongsTo(Category::class,'category_id');
    }
}
