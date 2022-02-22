<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Models\Material\Content;
use App\Models\Material\ContentImg;
use App\Models\Material\Material;
use App\Models\Pay\Order;
use App\Models\User\SubUser;
use App\Models\User\User;
use App\Services\User\FirstUser;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstUser = FirstUser::make();

        $attributes = [
            'id' => $firstUser->uid,
            'nickname' => $firstUser->nickname,
            'avatar' => $firstUser->avatar,
            'personal_signature' => '最有个性的签名',
            'balance' => 20,
            'total_income' => 30.99,
        ];
        User::create($attributes);
    }
}
