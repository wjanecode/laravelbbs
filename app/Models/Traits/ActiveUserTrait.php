<?php
namespace App\Models\Traits;


use App\Models\Post;
use App\Models\Reply;
use Carbon\Carbon;
use Cache;
use Arr;

/**
 * 添加活跃用户trait
 * Trait ActiveUserTrait
 * @package App\Models\Traits
 */
trait ActiveUserTrait
{
    // 用于存放临时用户数据
    protected $users = [];

    protected $active_post;
    protected $active_reply;
    protected $post_weight = 4;//帖子权重
    protected $reply_weight = 1;//回复权重
    protected $pass_days = 7;//几天内的统计数据
    protected $user_number = 6;//取出的用户数

    //缓存相关配置
    protected $cache_key = 'laravel_bbs_active_user';
    protected $cache_expire_in_seconds = 60*60;

    public function addActiveUser(  ) {

        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function(){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 并加以缓存
        $this->cacheActiveUsers($active_users);
    }

    public function calculateActiveUsers(  ) {

        //计算得分
        $this->calculatePostScore();
        $this->calculateReplyScore();

        //对得分进行排序,该方法排序后是小到大排序

        $users = Arr::sort($this->users,function ($user){
            return $user['score'];
        });
        //倒序,保持索引key不变
        $users = array_reverse($users,true);
        //只取所需的数量
        $users = array_slice($users,0,$this->user_number,true);


        //新建空集合
        $active_users = collect();
        foreach ($users as $user_id => $user){
            //查找用户
            $user = $this->find($user_id);
            //找到用户,添加到集合
            if($user){
                $active_users->push($user);
            }
        }

        //返回活跃用户集合
        return $active_users;
    }

    private function calculatePostScore(  ) {
        // 从话题数据表里取出限定时间范围（$pass_days）内，有发表过话题的用户
        // 并且同时取出用户此段时间内发布话题的数量

        //sql='select user_id, count(*) as post_count form 'posts' where created_at >= Carbon:now()->subDays(7) groupBy user_id'
        $post_users = \DB::table('posts')->select(\DB::raw('user_id,count(*) as post_count'))
            ->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        //计算话题得分
        foreach($post_users as $value){
            $this->users[$value->user_id]['score'] = $value->post_count * $this->post_weight;
        }

    }

    private function calculateReplyScore(  ) {

        //从回复表中获取限定时间内发过回复的用户
        //同时取出该用户此时间内的回复数量

        $reply_users = \DB::table('replies')
            ->select(\DB::raw('user_id,count(*) as reply_count'))
            ->where('created_at','>=',Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();

        //计算回复得分
        foreach ($reply_users as $value){
            $reply_score = $value->reply_count * $this->reply_weight;

            //判断帖子统计已存在分数
            if(isset($this->users[$value->user_id])){
                $this->users[$value->user_id]['score'] += $reply_score;
            }else{
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }
    private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
    }
}
