<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Models\Traits;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

/**
 * 记录用户最后登录时间
 * 每天的数据保存为一张hash表,保存到redis
 * 然后再把每天的定时同步到数据库
 * Trait RecordLastActive
 *
 * @package App\Models\Traits
 */
trait  RecordLastActive {

    //缓存相关
    //哈希表前缀,后面接每天日期
    protected $hash_prefix = 'record_user_active_at';
    //字段前缀,后面接user_id,保存的值就是这个用户每次请求的时间
    protected $field_prefix = 'user_';

    public function recordLastActiveTime(  ) {

        //获取今天日期
        $date = Carbon::now()->toDateString();

        //哈希表名
        $hash = $this->hash_prefix . $date;

        //字段名
        $field = $this->field_prefix . $this->id;

        //当前时间
        $now = Carbon::now()->toDateTimeString();

        //获取所有,测试一下
        //dd(Redis::hGetAll($hash));

        //写入数据库
        //你可以调用 Redis facade 上的各种方法来与 Redis 进行交互。Redis facade 支持动态方法，这意味着你可以在 facade 上调用 任何 Redis 命令 ，还能将该命令直接传递给 Redis。在本例中，通过调用 Redis facade 上的 get 方法来调用 Redis 的 GET 命令：
        //
        //也就是说你直接写 redis 的命令就可以了。
        //字段已存在会被更新
        //三个参数,第一个是要存的哈希表名,第二个字段名,第三个值
        Redis::hSet($hash,$field,$now);


    }

    /**
     * 同步昨天的redis数据到users表
     */
    public function syncUserActiveAt(  ) {

        //获取昨天的日期 格式为2020-7-1
        $date = Carbon::yesterday()->toDateString();

        //昨天保存的哈希表名
        $hash = $this->hash_prefix . $date;

        //获取表中的数据,得到的是数组,facade调用动态方法,可以直接使用redis的命令方法
        $data = Redis::hGetAll($hash);

        //遍历数组,把键 user_id 变成 id 去掉前缀
        foreach($data as $user_id => $active_at){

            //str_replace替换
            $user_id = str_replace($this->field_prefix,'',$user_id);

            //该用户存在时更新到用户表
            if($user = $this->find($user_id)){
                //update_at字段不应该更新
                $user->timestamps = false;
                //更新字段
                $user->last_active_at = $active_at;
                //保存
                $user->save();
            };
        }

        //以数据库为中心的存储，既已同步，即可删除,
        Redis::del($hash);
    }

    /**
     * 获取最后活跃时间,
     * 有三种情况,1.存在哈希表中,2.已同步到last_active_at字段,3.只注册没登录(获取created_at)
     * 希望返回的是一个Carbon对象,以使用diffForHumans()
     * laravel会自动把created_at和updated_at转为Carbon对象
     * 所以只要对哈希表和同步的取出的值进行转换
     * eloquent访问器
     * 方法格式getXXXAttribute($value)
     * 保存该字段时会自动调用修改器方法,对该值进行格式化
     * 访问器 getXXXAttribute($value),用于临时取出数据
     * @param $value
     *
     * @return Carbon
     * @throws \Exception
     */
    public function getLastActiveAtAttribute($value){

        //哈希表和字段,表只存了今天的,昨天的同步时就删了
        $hash = $this->hash_prefix . Carbon::now()->toDateString();
        $field = $this->field_prefix . $this->id;

        //三元运算符,优先取redis的值
        $active_at = Redis::hGet($hash,$field) ? : $value;

        //如果也没有同步到数据库,那就取注册时间
        if ($active_at){

            //取到值,转为Carbon对象返回
            return new Carbon($active_at);
        } else {

            //使用注册时间,laravel 会自动把created_at updated_at 转为Carbon对象
            return $this->created_at;
        }
    }
}
