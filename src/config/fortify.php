<?php

use Laravel\Fortify\Features;

return [
    'guard'     => 'web',
    'middleware' => ['web'],
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username'  => 'email',
    'email'     => 'email',
    'lowercase_usernames' => true,
    'home' => '/',
    'prefix' => '',
    'domain' => null,
    'views'  => true,
    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
    ],
    'limiters' => [
        'login'        => 'login',
        'two-factor'   => 'two-factor',
    ],
    'login_throttle_key' => null,
    'confirmPasswordsFor' => [],
];
