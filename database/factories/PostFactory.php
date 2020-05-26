<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Post::class, function (Faker $faker) {

    $updated_at = $faker->dateTimeThisMonth();//这个月内的随机时间
    $created_at = $faker->dateTimeThisMonth($updated_at);//更改比生成要晚

    return [
        // 'name' => $faker->name,
        'title' => $faker->sentence,
        'body' => $faker->text,

        'created_at' => $created_at,
        'updated_at' => $updated_at
    ];
});
