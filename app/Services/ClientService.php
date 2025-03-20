<?php


namespace App\Services;

use App\Repositories\ClientRepository;

class ClientService
{
    protected $clientRepo;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

    public function getAllClients($perPage = 10)
    {
        return $this->clientRepo->all($perPage);
    }

    public function createClient(array $data)
    {
        return $this->clientRepo->create($data);
    }

    public function updateClient($id, array $data)
    {
        $client = $this->clientRepo->find($id);
        return $this->clientRepo->update($client, $data);
    }

    public function deleteClient($id)
    {
        $client = $this->clientRepo->find($id);
        return $this->clientRepo->delete($client);
    }
}