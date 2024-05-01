<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Notification;
use App\Utils\DBConnection;
use Exception;
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

        try {
            $targetedUserId = (new QuestionService())->getById($data->getQuestionId())->getUserId();
            $notification = new Notification(
                0,
                $data->getUserId(),
                $targetedUserId,
                'answer',
                $data->getQuestionId(),
                false
            );

            $notificationService = new NotificationService();

            $notificationService->create(
                $notification
            );
        } catch (Exception $ex) {
            var_dump($ex);
        }

        return $this->db->lastInsertId();
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM Answers WHERE answer_id = :answer_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['answer_id' => $id]);
        $answerData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Answer(
            $answerData['user_id'],
            $answerData['question_id'],
            $answerData['body'],
            $answerData['created_at'],
            $answerData['answer_id'],
            $answerData['reputations']
        );
    }

    public function getAll()
    {
        $query = "SELECT * FROM Answers";
        $stmt = $this->db->query($query);
        $answerDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $answers = [];
        foreach ($answerDataArray as $answerData) {
            $answers[] = new Answer(
                $answerData['user_id'],
                $answerData['question_id'],
                $answerData['body'],
                $answerData['created_at'],
                $answerData['answer_id'],
                $answerData['reputations']
            );
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

    public function getAnswersByQuestionID($questionID)
    {
        $query = "SELECT * FROM Answers WHERE question_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$questionID]); // Use array parameter binding for PDO
        $answersDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $answers = [];
        foreach ($answersDataArray as $answerInfo) {
            $answers[] = new Answer(
                $answerInfo['user_id'],
                $answerInfo['question_id'],
                $answerInfo['body'],
                $answerInfo['created_at'],
                $answerInfo['answer_id'],
                $answerInfo['reputations']
            );
        }
        return $answers;
    }
}

?>