<?php

namespace App\Models;

class Answer {
    public int $answer_id;
    public int $user_id;
    public int $question_id;
    public string $body;
    public string $created_at;
    public int $reputations;

    public function __construct(int $answer_id, int $user_id, int $question_id, string $body, string $created_at, int $reputations) {
        $this->answer_id = $answer_id;
        $this->user_id = $user_id;
        $this->question_id = $question_id;
        $this->body = $body;
        $this->created_at = $created_at;
        $this->reputations = $reputations;
    }
}