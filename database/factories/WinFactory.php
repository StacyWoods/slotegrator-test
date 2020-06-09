<?php

/** @var Factory $factory */

use App\Models\TypePrize;
use App\Models\Win;
use App\Models\User;
use App\Models\Status;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Win::class, function (Faker $faker) {
    return [
        'value' => $faker->numberBetween(2000,100000),
        'status_id' => (Status::whereSlug('pending')->get()->first())->id,
        'type_prize_id' => (TypePrize::whereTitle('money')->get()->first())->id,
        'user_id' => function () {
            return create(User::class)->id;
        },
        'goods_id' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
    ];
});
