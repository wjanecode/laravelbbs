<?php

namespace App\Models;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property int $category_id
 * @property int $reply_count
 * @property int $view_count
 * @property int $last_reply_user_id
 * @property int $order
 * @property string|null $excerpt
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model recent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post recentPublish()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post recentReply()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereLastReplyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereReplyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withOrder($order)
 * @mixin \Eloquent
 */
class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id',  'last_reply_user_id', 'excerpt', 'slug'];

    /**
     * 一对一,一个帖子属于一个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(  ) {
        return $this->belongsTo(User::class);
    }

    /**
     * 一对一 一个帖子属于一个分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(  ) {
        return $this->belongsTo(Category::class,'category_id');
    }

    /**
     * 一对多,一个贴子拥有多个回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(  ) {
        return $this->hasMany(Reply::class,'post_id','id');
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

    //更新回复统计
    public function updateRepliesCount(  ) {

        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
