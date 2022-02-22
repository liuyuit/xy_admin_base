<?php

namespace Database\Factories\User;

use App\Enums\MemberLevel;
use App\Models\User\SubUser;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nickname' => $this->faker->name,
            'avatar' => $this->faker->imageUrl(),
        ];
    }

    /**
     * 配置模型工厂。
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) {
            /*SubUser::create([
                'openid' => $this->faker->bothify('#############??????????????'),
                'uid' => $user->id,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
            ]);*/
        });
    }
}
