<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = [ 'content'];//只允许用户修改内容字段

    /**
     * 数据关联,一条回复只属于一个帖子
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(  ) {
        return $this->belongsTo(Post::class);
    }

    /**
     * 数据关联,一条回复只属于一个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(  ) {
        return $this->belongsTo(User::class);
    }
}
