<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)->create();
        /*
        factory(App\Models\User::class, 4)->create()->each(function ($user) {
            factory(App\Models\FollowUser::class)->create(['user_id' => 1, 'followed_user_id' => $user->id]);
            factory(App\Models\FollowUser::class)->create(['user_id' => $user->id, 'followed_user_id' => 1]);
        });
        */
    }
}
