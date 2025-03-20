<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;

interface ClientRepositoryInterface
{
    public function all(int $perPage = 10); 
    public function create(array $data); 
    public function find(int $id); 
    public function update(int $id, array $data); 
    public function delete(Client $client); 
}