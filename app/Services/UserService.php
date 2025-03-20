<?php

// app/Services/UserService.php

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

    public function completeRegistration(string $cpf)
    {
        try {
            $user = $this->userRepository->findByCpf($cpf);
            
            if (!$user) {
                throw new Exception('Usuário não encontrado');
            }

            $updated = $this->userRepository->updateStatus($user->id, 'completed');
            
            if (!$updated) {
                throw new Exception('Não foi possível atualizar o status do usuário');
            }

            return $updated;
        } catch (Exception $e) {
            Log::error('Erro ao completar registro', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    // Adicione outros métodos conforme necessário
}