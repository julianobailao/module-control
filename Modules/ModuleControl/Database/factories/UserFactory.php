<?php

$factory->define(\Modules\ModuleControl\Entities\User::class, function (Faker\Generator $faker) {
    static $password, $user_group_id;

    return [
        'user_group_id' => $user_group_id > 0 ? $user_group_id : factory(\Modules\ModuleControl\Entities\UserGroup::class)->create()->id,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
