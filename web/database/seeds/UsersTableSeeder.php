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
        DB::table('users')->insert([
            'name' => 'ゆと',
            'email' => 'a@a.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        factory(App\Models\User::class, 25)->create()->each(function ($user) {
            factory(App\Models\Post::class)->create(['user_id' => $user->id ]);
            factory(App\Models\Profile::class)->create(['user_id' => $user->id ]);
            factory(App\Models\FollowUser::class)->create(['user_id' => 1, 'followed_user_id' => $user->id]);
            factory(App\Models\FollowUser::class)->create(['user_id' => $user->id, 'followed_user_id' => 1]);
        });
    }
}
