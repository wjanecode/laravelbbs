<?php

namespace App\Models;

use App\Models\Traits\ActiveUserTrait;
use App\Models\Traits\RecordLastActive;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $introduce
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $notification_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $post
 * @property-read int|null $post_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read int|null $replies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIntroduce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;//权限拓展包的所有方法
    use ActiveUserTrait;//活跃用户
    use RecordLastActive;//记录最后登录时间

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduce','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 一多关联,用户用户拥有多个帖子
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function post(  ) {
        return $this->hasMany(Post::class);
    }

    /**
     * 一对多,一个用户拥有多个回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(  ) {
        return $this->hasMany(Reply::class,'user_id','id');
    }

    /**
     * 模型从属,判断模型是否属于该用户
     * @param $model
     *
     * @return bool
     */
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 未读通知改已读
     */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    /**
     * eloquent修改器
     * 方法格式setXXXAttribute($value)
     * 保存该字段时会自动调用修改器方法,对该值进行格式化
     * 访问器 getXXXAttribute(),用于临时取出数据
     * @param $value
     */
    public function setPasswordAttribute( $value ) {

        //果然密码长度等于60,就是已经执行加密了
        //对未加密的进行加密
        if(strlen($value) != 60){
            $value =bcrypt($value);
        }

        //保存值,attributes[]数组
        $this->attributes['password'] = $value;

    }

    public function setAvatarAttribute( $value ) {

        //administrator插件保存头像不保存路径,处理一下,确保所有入库的头像带路径
        //没找到路径分隔符
        if(! (strchr($value,'/') || strchr($value,'\\')) ){
            //补全路径
            $value = '/upload/images/avatar/'.$value;
        }
        $this->attributes['avatar'] = $value;
    }


}
