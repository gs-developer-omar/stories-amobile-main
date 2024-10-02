<?php

use App\Http\Controllers\api\v1\StoriesController;
use App\Http\Controllers\api\v1\StoryItemStoryItemButtonsController;
use App\Http\Controllers\api\v1\StoryStoryCommentsController;
use App\Http\Controllers\api\v1\StoryStoryItemsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api_key_checkout')->group(function() {
    Route::get('/stories', [StoriesController::class, 'index']);
    Route::get('/stories/{story}', [StoriesController::class, 'show']);
    Route::post('/stories/{story}/watch', [StoriesController::class, 'watchStory']);
    Route::post('/stories/{story}/like', [StoriesController::class, 'likeStory']);
    Route::get('/stories/{story}/story-items', [StoryStoryItemsController::class, 'index']);
    Route::get('/stories/{story}/story-items/{storyItemId}', [StoryStoryItemsController::class, 'show']);
    Route::get('/story-items/{storyItem}/story-item-buttons', [StoryItemStoryItemButtonsController::class, 'index']);

    Route::get('/stories/{story}/comments', [StoryStoryCommentsController::class, 'index']);
    Route::get('/stories/{story}/comments/{storyCommentId}', [StoryStoryCommentsController::class, 'show']);
    Route::post('/stories/{story}/comments', [StoryStoryCommentsController::class, 'store']);
    Route::patch('/stories/{story}/comments/{storyComment}', [StoryStoryCommentsController::class, 'update']);
    Route::delete('/stories/{story}/comments/{storyComment}', [StoryStoryCommentsController::class, 'destroy']);
});