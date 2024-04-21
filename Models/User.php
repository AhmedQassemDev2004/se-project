<?php

namespace App\Models;

class User {
    public int $user_id;
    public string $username;
    public string $email;
    public string $password;
    public ?string $photo;
    public string $created_at;
    public int $reputations; 
    public string $role;

    public function __construct(int $user_id, string $username, string $email, string $password, ?string $photo, string $created_at, int $reputations, string $role) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        $this->created_at = $created_at;
        $this->reputations = $reputations;
        $this->role = $role;
    }
}
