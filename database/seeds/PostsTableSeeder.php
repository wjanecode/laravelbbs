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
        $user_ids = User::all()->pluck('id')->toArray();//user_id 数组
        $category_ids = Category::all()->pluck('id')->toArray();//category_id 数组
        $posts = factory(Post::class)->times(50)->make()->each(function ($post, $index) use ($user_ids,$category_ids){
            $post->user_id = $user_ids[array_rand($user_ids,1)];
            $post->category_id = $category_ids[array_rand($category_ids,1)];
        });

        Post::insert($posts->toArray());
    }

}

