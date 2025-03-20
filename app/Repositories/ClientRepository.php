<?php

#app/Repositories/ClientRepository.php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function all($perPage = 10)
    {
        return Client::paginate($perPage);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function find($id)
    {
        return Client::findOrFail($id);
    }

    public function update(Client $client, array $data)
    {
        return $client->update($data);
    }

    public function delete(Client $client)
    {
        return $client->delete();
    }
}