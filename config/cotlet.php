<?php

return [
    'user_model' => env('COTLET_USER_MODEL', 'App\Models\User'),
    'username_field' => env('COTLET_USERNAME_FIELD', 'email'),
    'password_field' => env('COTLET_PASSWORD_FIELD', 'password'),
    'routes' => [
        'login' => env('COTLET_LOGIN_ROUTE', 'auth/login')
    ]
];
