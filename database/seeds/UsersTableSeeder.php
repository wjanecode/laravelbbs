<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $avatars = [
            'upload/images/avatar/202005/27/avatar-10-21-048608.png',
            'upload\images\avatar\202005\26\avatar-15-41-396821.png',
            'upload\images\avatar\202005\26\avatar-16-11-421623.jpg',
            'upload\images\avatar\202006\24\avatar-08-27-069830.jpg'
        ];

        $users = factory(User::class)->times(10)->make()->each(function ($user, $index) use ($avatars) {
            $user->avatar = $avatars[array_rand($avatars)];
        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'test';
        $user->email = 'test@example.com';
        $user->save();
        //给第一个用户分配站站长角色
        $user->assignRole('Founder');
        //给第二个用户分配管理员角色
        $user = User::find(2);
        $user->assignRole('Maintainer');


    }
}
