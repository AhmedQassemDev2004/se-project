<?php

namespace App\Services;

interface Service
{
    public function add_vote(object $data);
    public function getById(int $id);
    public function getAll();
    public function update(int $id, object $data);
    public function delete(int $id);
}
