<?php

namespace App\Services;

use App\Models\Question;
use App\Utils\DBConnection;
use PDO;

class QuestionService implements Service
{
    private $db;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->db = $dbConnection->getConnection();
    }

    public function create(object $data)
    {
        $query = "INSERT INTO Questions (user_id, title, body, created_at, updated_at, reputations) VALUES (:user_id, :title, :body, :created_at, :updated_at, :reputations)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'user_id' => $data->user_id,
            'title' => $data->title,
            'body' => $data->body,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'reputations' => $data->reputations
        ]);
        return $this->db->lastInsertId();
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM Questions WHERE question_id = :question_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['question_id' => $id]);
        $questionData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Question($questionData['question_id'], $questionData['user_id'], $questionData['title'], $questionData['body'], $questionData['created_at'], $questionData['updated_at'], $questionData['reputations']);
    }

    public function getAll()
    {
        $query = "SELECT * FROM Questions";
        $stmt = $this->db->query($query);
        $questionDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $questions = [];
        foreach ($questionDataArray as $questionData) {
            $questions[] = new Question($questionData['question_id'], $questionData['user_id'], $questionData['title'], $questionData['body'], $questionData['created_at'], $questionData['updated_at'], $questionData['reputations']);
        }
        return $questions;
    }

    public function update(int $id, object $data)
    {
        $query = "UPDATE Questions SET user_id = :user_id, title = :title, body = :body, created_at = :created_at, updated_at = :updated_at, reputations = :reputations WHERE question_id = :question_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'question_id' => $id,
            'user_id' => $data->user_id,
            'title' => $data->title,
            'body' => $data->body,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'reputations' => $data->reputations
        ]);
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM Questions WHERE question_id = :question_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['question_id' => $id]);
    }
}

?>