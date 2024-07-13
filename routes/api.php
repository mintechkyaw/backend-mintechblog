<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReactionController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;

Route::apiResource('posts', PostController::class)->only(['index', 'show'])->middleware('authoptional');

Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

Route::apiResource('comments', CommentController::class)->middleware('auth:sanctum');

Route::apiResource('reactions', ReactionController::class)->middleware('auth:sanctum');

require __DIR__ . '/auth.php';
