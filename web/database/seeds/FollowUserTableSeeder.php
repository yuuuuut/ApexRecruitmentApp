<?php

use Illuminate\Database\Seeder;

class FollowUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\Models\FollowUser::class, 20)->create();
    }
}
