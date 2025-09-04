<?php

use App\Http\Controllers\abaza_api\AbazaController;
use App\Http\Controllers\acquiring_faq_api\AcquiringFaqController;
use App\Http\Controllers\api\v1\EmojiReactionController;
use App\Http\Controllers\api\v1\StoryController;
use App\Http\Controllers\api\v1\StoryItemButtonController;
use App\Http\Controllers\api\v1\StoryCommentController;
use App\Http\Controllers\api\v1\StoryItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware([
    'api_key_auth',
    'amobile_auth'
])->group(function() {
    Route::get('/stories', [StoryController::class, 'index']);
    Route::get('/stories/{story}', [StoryController::class, 'show']);
    Route::post('/stories/{story}/watch', [StoryController::class, 'watchStory']);
    Route::post('/stories/{story}/like', [StoryController::class, 'likeStory']);
    Route::get('/stories/{story}/story-items', [StoryItemController::class, 'index']);
    Route::get('/stories/{story}/story-items/{storyItemId}', [StoryItemController::class, 'show']);
    Route::get('/story-items/{storyItem}/story-item-buttons', [StoryItemButtonController::class, 'index']);

    Route::get('/stories/{story}/comments', [StoryCommentController::class, 'index']);
    Route::get('/stories/{story}/comments/{storyCommentId}', [StoryCommentController::class, 'show']);
    Route::post('/stories/{story}/comments', [StoryCommentController::class, 'store']);
    Route::patch('/stories/{story}/comments/{storyComment}', [StoryCommentController::class, 'update']);
    Route::delete('/stories/{story}/comments/{storyComment}', [StoryCommentController::class, 'destroy']);

    Route::get('/stories/{story}/comments/{storyComment}/reactions', [EmojiReactionController::class, 'index']);
    Route::post('/stories/{story}/comments/{storyComment}/reactions', [EmojiReactionController::class, 'addReaction']);
    Route::delete('/stories/{story}/comments/{storyComment}/reactions', [EmojiReactionController::class, 'removeReaction']);
    Route::delete('/stories/delete-all-comments', [StoryCommentController::class, 'deleteAllComments']);
});
Route::prefix('v1')->group(function() {
    Route::middleware(['abaza_requests'])
        ->post('/abaza/send-user-data-to-manager', [AbazaController::class, 'sendUserDataToManager'])
        ->name('abaza.send-user-data-to-manager');

    Route::middleware(['acquiring_faq_middleware'])
        ->post('/acquiring/send-user-data-to-manager', AcquiringFaqController::class)
        ->name('acquiring.send-user-data-to-manager');
});
