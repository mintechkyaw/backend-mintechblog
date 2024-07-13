<?php

use Illuminate\Support\Facades\Route;

Route::view('/welcome','welcome');

Route::redirect('/','/admin');
