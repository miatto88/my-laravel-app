<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\aggregate;
use Faker\Generator as Faker;

$factory->define(aggregate::class, function (Faker $faker) {
    return [
        'aggregate_new_tasks' => '0',
        'aggregate_complete_tasks' => '0',
        'aggregate_incomplete_tasks' => '0',
    ];
});
