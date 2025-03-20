<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'cpf' => $data['cpf'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 'in_progress'
        ]);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function findByCpf(string $cpf)
    {
        return User::where('cpf', $cpf)->first();
    }

    public function updateStatus(int $userId, string $status)
    {
        return User::find($userId)->update(['status' => $status]);
    }
}