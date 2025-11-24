<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)
            ->where('is_active', true)
            ->first();
    }

    public function getAll(?string $search = null): LengthAwarePaginator
    {
        $query = User::with('role');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $userId, array $data): bool
    {
        return User::where('id', $userId)->update($data);
    }

    public function delete(int $userId): bool
    {
        return User::where('id', $userId)->delete();
    }

    public function findById(int $userId): ?User
    {
        return User::with('role')->find($userId);
    }
}