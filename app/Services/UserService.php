<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        try {
            $user = $this->userRepository->create($data);
            Log::info('Usuário criado com sucesso', ['user' => $user->id]);
            return $user;
        } catch (Exception $e) {
            Log::error('Erro ao criar usuário', ['error' => $e->getMessage()]);
            throw new Exception('Não foi possível criar o usuário');
        }
    }
}