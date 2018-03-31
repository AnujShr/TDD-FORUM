<?php

use Faker\Generator as Faker;


$factory->define(App\User::class, function (Faker $faker) {
    return ['name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'confirmed' => true];
});

$factory->state(App\User::class, 'unconfirmed', function () {
    return ['confirmed' => false];
});

$factory->state(App\User::class, 'administrator', function () {
    return ['name' => 'JohnDoe'];
});

$factory->define(App\Thread::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'user_id' => function () {
        return factory('App\User')->create()->id;
    },
        'channel_id' => function () {
        return factory('App\Channel')->create()->id;
    },
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' =>str_slug($title),
        'locked' => false]
    ;
});

$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->word;

    return ['name' => $name, 'slug' => str_slug($name)];
});

$factory->define(App\Reply::class, function (Faker $faker) {
    return ['user_id' => function () {
        return factory('App\User')->create()->id;
    },
        'thread_id' => function () {
        return factory('App\Thread')->create()->id;
    },
        'body' => $faker->paragraph];
});
$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return ['id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
        return auth()->id() ?: factory('App\User')->create()->id;
    },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']];
});
