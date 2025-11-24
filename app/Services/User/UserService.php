<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function getAllUsers(?string $search = null): LengthAwarePaginator
    {
        return $this->userRepository->getAll($search);
    }

    public function createUser(CreateUserDTO $userData): User
    {
        return $this->userRepository->create([
            'role_id' => $userData->roleId,
            'name' => $userData->name,
            'email' => $userData->username . '@system.local',
            'phone' => $userData->phone,
            'whatsapp_number' => $userData->whatsappNumber,
            'username' => $userData->username,
            'password' => Hash::make($userData->password),
            'is_active' => $userData->isActive,
        ]);
    }

    public function updateUser(int $userId, UpdateUserDTO $userData): bool
    {
        $data = [
            'role_id' => $userData->roleId,
            'name' => $userData->name,
            'email' => $userData->username . '@system.local',
            'phone' => $userData->phone,
            'whatsapp_number' => $userData->whatsappNumber,
            'username' => $userData->username,
            'is_active' => $userData->isActive,
        ];

        if ($userData->password) {
            $data['password'] = Hash::make($userData->password);
        }

        return $this->userRepository->update($userId, $data);
    }

    public function deleteUser(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    public function findUserById(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }
}
