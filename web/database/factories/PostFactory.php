<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'user_id' => fn() => factory(App\Models\User::class)->create()->id,
        'content' => 'TC',
        'myid' => 'TestID',
        'platform' => 'PS4'
    ];
});
