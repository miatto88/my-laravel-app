<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\aggregate;
use Faker\Generator as Faker;

$factory->define(aggregate::class, function (Faker $faker) {
    return [
        'aggregate_new_task_count' => '0',
        'aggregate_complete_task_count' => '0',
        'aggregate_incomplete_task_count' => '0',
    ];
});
