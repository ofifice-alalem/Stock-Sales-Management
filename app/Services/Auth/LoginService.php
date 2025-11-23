<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTOs\Auth\LoginRequestDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function authenticate(LoginRequestDTO $loginData): ?User
    {
        $user = $this->userRepository->findByUsername($loginData->username);

        if (!$user || !Hash::check($loginData->password, $user->password)) {
            return null;
        }

        return $user;
    }
}