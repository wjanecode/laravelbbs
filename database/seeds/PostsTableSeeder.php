<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $user_ids = User::all()->pluck('id')->toArray();//从User获取user_id字段,转为数组
        $category_ids = Category::all()->pluck('id')->toArray();//从分类获取category_id字段,转为数组

        $posts = factory(Post::class)
            ->times(100)//一百个
            ->make()//生成数据转集合collection
            ->each(function ($post, $index) use ($user_ids,$category_ids){
                //插入字段,随机分配
                //array_rand — 从数组中随机取出一个或多个单元
                $post->user_id = $user_ids[array_rand($user_ids,1)];
                $post->category_id = $category_ids[array_rand($category_ids,1)];
        });

        Post::insert($posts->toArray());
    }

}

