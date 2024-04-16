<?php

namespace App\Models;

class Question {
    public int $question_id;
    public int $user_id;
    public string $title;
    public string $body;
    public string $created_at;
    public string $updated_at;
    public int $reputations;

    public function __construct(int $question_id, int $user_id, string $title, string $body, string $created_at, string $updated_at, int $reputations) {
        $this->question_id = $question_id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->body = $body;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->reputations = $reputations;
    }
}