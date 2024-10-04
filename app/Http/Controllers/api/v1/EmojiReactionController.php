<?php

namespace App\Http\Controllers\api\v1;

use App\Enums\api\v1\HTTP_EVENT;
use App\Http\Resources\v1\EmojiReactionResource;
use App\Models\AmobileUser;
use App\Models\EmojiReaction;
use App\Models\Story;
use App\Models\StoryComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmojiReactionController extends ApiController
{
    public function index(Request $request, Story $story, int $storyCommentId): AnonymousResourceCollection
    {
        AmobileUser::authenticateAmobileUser($request->input('phone'));

        StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id
        ])->firstOrFail();

        return EmojiReactionResource::collection(EmojiReaction::where([
            'story_comment_id' => $storyCommentId,
        ])->get());
    }
    public function addReaction(Request $request, Story $story, int $storyCommentId): JsonResponse
    {
        $request->validate([
            'emoji' => 'required|string|max:10'
        ]);

        $phone = $request->input('phone');

        AmobileUser::authenticateAmobileUser($phone);

        $storyComment = StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id
        ])->firstOrFail();

        $emojiReaction = EmojiReaction::where([
            'story_comment_id' => $storyCommentId,
            'phone' => $phone,
        ])->first();

        if ($emojiReaction) {
            $emojiReaction->emoji = $request->input('emoji');
            $emojiReaction->save();
        } else {
            $emojiReaction = EmojiReaction::create([
                'story_comment_id' => $storyComment->id,
                'phone' => $phone,
                'emoji' => $request->input('emoji'),
            ]);
        }

        return response()->json([
            'event' => HTTP_EVENT::CREATED,
            'message' => "Реакция {$emojiReaction->emoji} была успешна добавлена к комментарию",
            'data' => new EmojiReactionResource($emojiReaction)
        ], 201);
    }

    public function removeReaction(Request $request, Story $story, int $storyCommentId): JsonResponse
    {
        $phone = $request->input('phone');

        AmobileUser::authenticateAmobileUser($phone);

        StoryComment::where([
            'id' => $storyCommentId,
            'story_id' => $story->id
        ])->firstOrFail();

        $emojiReaction = EmojiReaction::where([
            'story_comment_id' => $storyCommentId,
            'phone' => $phone,
        ])->first();

        if ($emojiReaction) {
            $emojiReaction->delete();
            return response()->json([
                'event' => HTTP_EVENT::DELETED,
                'message' => 'Реакция была успешно удалена',
                'data' => [
                    'phone' => $phone,
                    'story_id' => $story->id,
                    'comment_id' => $storyCommentId
                ]
            ]);
        } else {
            return response()->json([
                'event' => HTTP_EVENT::UNCHANGED,
                'message' => "Пользователь с номером телефона {$phone} не оставлял реакции для комментария с id {$storyCommentId}",
                'data' => [
                    'phone' => $phone,
                    'story_id' => $story->id,
                    'comment_id' => $storyCommentId
                ]
            ]);
        }
    }
}
