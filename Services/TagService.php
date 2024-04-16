<?php

namespace App\Services;

use App\Models\Tag;
use App\Utils\DBConnection;
use PDO;

class TagService implements Service
{
    private $db;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->db = $dbConnection->getConnection();
    }

    public function create(object $data)
    {
        $query = "INSERT INTO Tags (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['name' => $data->name]);
        return $this->db->lastInsertId();
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM Tags WHERE tag_id = :tag_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['tag_id' => $id]);
        $tagData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Tag($tagData['tag_id'], $tagData['name']);
    }

    public function getAll()
    {
        $query = "SELECT * FROM Tags";
        $stmt = $this->db->query($query);
        $tagDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tags = [];
        foreach ($tagDataArray as $tagData) {
            $tags[] = new Tag($tagData['tag_id'], $tagData['name']);
        }
        return $tags;
    }

    public function update(int $id, object $data)
    {
        $query = "UPDATE Tags SET name = :name WHERE tag_id = :tag_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['tag_id' => $id, 'name' => $data->name]);
    }

    public function delete(int $id)
    {
        $query = "DELETE FROM Tags WHERE tag_id = :tag_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['tag_id' => $id]);
    }
}