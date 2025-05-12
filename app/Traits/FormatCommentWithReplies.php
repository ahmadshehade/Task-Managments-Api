<?php

namespace App\Traits;

trait FormatCommentWithReplies
{
    /**
     * Summary of formatCommentWithReplies
     * @param mixed $comment
     * @return array[]|array{body: mixed, id: mixed, replies: array, user: mixed}
     */
    public function formatCommentWithReplies( $comment){
           $formatted = [
            'id' => $comment->id,
            'body' => $comment->body,
            'user' => $comment->user?->name,
            'replies' => []
            ];

            foreach ($comment->replaies as $reply) {
              $formatted['replies'][] = $this->formatCommentWithReplies($reply); // recursive
           }
           return $formatted;
    }
}
