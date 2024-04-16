<?php

namespace App\Services;

use App\Models\Answer;
use App\Utils\DBConnection;
use PDO;

class AnswerService implements Service
{
    private $db;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->db = $dbConnection->getConnection();
    }

    public function create(object $data)
    {
        $query = "INSERT INTO Answers (user_id, question_id, body, created_at, reputations) VALUES (:user_id, :question_id, :body, :created_at, :reputations)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'user_id' => $data->user_id,
            'question_id' => $data->question_id,
            'body' => $data->body,
            'created_at' => $data->created_at,
            'reputations' => $data->reputations
        ]);
        return $this->db->lastInsertId();
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM Answers WHERE answer_id = :answer_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['answer_id' => $id]);
        $answerData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Answer($answerData['answer_id'], $answerData['user_id'], $answerData['question_id'], $answerData['body'], $answerData['created_at'], $answerData['reputations']);
    }

    public function getAll()
    {
        $query = "SELECT * FROM Answers";
        $stmt = $this->db->query($query);
        $answerDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $answers = [];
        foreach ($answerDataArray as $answerData) {
            $answers[] = new Answer($answerData['answer_id'], $answerData['user_id'], $answerData['question_id'], $answerData['body'], $answerData['created_at'], $answerData['reputations']);
        }
        return $answers;
    }

    public function update(int $id, object $data)
    {
        $query = "UPDATE Answers SET user_id = :user_id, question_id = :question_id, body = :body, created_at = :created_at, reputations = :reputations WHERE answer_id = :answer_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'answer_id' => $id,
            'user_id' => $data->user_id,
            'question_id' => $data->question_id,
            'body' => $data->body,
            'created_at' => $data->created_at,
            'reputations' => $data->reputations
        ]);
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM Answers WHERE answer_id = :answer_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['answer_id' => $id]);
    }
}