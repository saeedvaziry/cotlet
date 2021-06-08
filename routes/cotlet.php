<?php

use Illuminate\Support\Facades\Route;

Route::post(config('cotlet.routes.login'), 'SaeedVaziry\Cotlet\Controllers\LoginController@login')->name('cotlet.login');
