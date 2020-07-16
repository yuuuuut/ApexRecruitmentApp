<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\FollowUser;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(FollowUser::class, function (Faker $faker) {
    return [
        'user_id' => fn() => 1,
        'followed_user_id' => fn() => factory(User::class)->create()->id,
    ];
});
