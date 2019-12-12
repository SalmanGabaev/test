<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Section;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {

    // download image from lorempixel.com
    $imageDownload = $faker->image(storage_path('app/public/logo'), 200, 180);

    // make array from value path
    $imagePath = explode('\\', $imageDownload);

    // make name image
    $imageName = end($imagePath);

    return [
        'name' => $faker->sentence(rand(3, 6), true) ,
        'description' => $faker->realText(rand(50, 200)),
        'logo' => $imageName,
    ];
});
