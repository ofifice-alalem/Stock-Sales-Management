<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;
    public function getAll(?string $search): LengthAwarePaginator;
    public function create(array $data): User;
    public function update(int $userId, array $data): bool;
    public function delete(int $userId): bool;
    public function findById(int $userId): ?User;
}