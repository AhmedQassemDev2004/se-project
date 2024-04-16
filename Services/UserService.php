<?php

namespace App\Services;

use App\Models\User;
use App\Utils\DBConnection;
use PDO;

class UserService implements Service
{
    private $db;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->db = $dbConnection->getConnection();
    }

    public function create(object $data): int
    {
        $query = "INSERT INTO Users (username, email, password, photo, created_at, reputations, role) 
                  VALUES (:username, :email, :password, :photo, :created_at, :reputations, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'username' => $data->username,
            'email' => $data->email,
            'password' => $data->password,
            'photo' => $data->photo,
            'created_at' => $data->created_at,
            'reputations' => $data->reputations,
            'role' => $data->role
        ]);
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?User
    {
        $query = "SELECT * FROM Users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new User(
                $userData['user_id'],
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['photo'],
                $userData['created_at'],
                $userData['reputations'],
                $userData['role']
            );
        }

        return null;
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM Users";
        $stmt = $this->db->query($query);
        $userDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($userDataArray as $userData) {
            $users[] = new User(
                $userData['user_id'],
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['photo'],
                $userData['created_at'],
                $userData['reputations'],
                $userData['role']
            );
        }
        return $users;
    }

    public function update(int $id, object $data): void
    {
        $query = "UPDATE Users SET username = :username, email = :email, password = :password, 
                  photo = :photo, created_at = :created_at, reputations = :reputations, role = :role 
                  WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'user_id' => $id,
            'username' => $data->username,
            'email' => $data->email,
            'password' => $data->password,
            'photo' => $data->photo,
            'created_at' => $data->created_at,
            'reputations' => $data->reputations,
            'role' => $data->role
        ]);
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM Users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $id]);
    }

    public function getUserByUsername(string $username): ?User
    {
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['username' => $username]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new User(
                $userData['user_id'],
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['photo'],
                $userData['created_at'],
                $userData['reputations'],
                $userData['role']
            );
        }

        return null;
    }

    public function getUserByEmail(string $email)
    {
        $query = "SELECT * FROM Users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new User(
                $userData['user_id'],
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['photo'],
                $userData['created_at'],
                $userData['reputations'],
                $userData['role']
            );
        }

        return null;
    }
}
