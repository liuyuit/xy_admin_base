<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Models\Material\Content;
use App\Models\Material\ContentImg;
use App\Models\Material\Material;
use App\Models\Material\SubscribeMaterial;
use App\Models\Pay\Order;
use App\Models\User\Subscribe;
use App\Models\User\User;
use App\Services\User\FirstUser;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(5)->create();

    }
}
