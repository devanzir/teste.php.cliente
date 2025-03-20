<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function findByCpf(string $cpf);
    public function updateStatus(int $userId, string $status);
}
