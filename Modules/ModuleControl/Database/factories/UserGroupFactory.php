<?php

$factory->define(\Modules\ModuleControl\Entities\UserGroup::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
