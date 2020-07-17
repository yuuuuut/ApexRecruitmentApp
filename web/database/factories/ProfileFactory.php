<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Profile;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => fn() => factory(User::class)->create()->id,
        'psid' => 'test_user',
        'content' => $faker->text(),
        'platform' => 'ps4',
    ];
});
