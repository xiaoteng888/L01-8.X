<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;
        // 获取去除掉 ID 为 1 的所有用户 ID 数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();
        //关注除了1号用户以外的所有用户
        $user->follow($follower_ids);
        //除了一号以外的用户都来关注一号
        foreach($followers as $follower)
        {
            $follower->follow($user_id);
        }
    }
}
