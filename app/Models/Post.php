<?php

namespace App\Models;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id',  'last_reply_user_id', 'excerpt', 'slug'];

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

    //scope范围查询限定
    public function scopeWithOrder($query,$order) {
        switch ($order){
            //最新发布
            case 'recent':
                $query->recentPublish();
                break;
            //最新回复
            case 'reply':
                $query->recentReply();
                break;
            //没有限制直接返回查询
            default:
                return $query;
        }
    }
    //最新发布
    public function scopeRecentPublish($query) {
        return $query->orderBy('created_at','desc');
    }
    //最新回复
    public function scopeRecentReply($query) {
        return $query->orderBy('updated_at','desc');
    }
}
