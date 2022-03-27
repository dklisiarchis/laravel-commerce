<?php
declare(strict_types=1);

namespace App\Solution\User\Services;

use App\Solution\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{

    public function getById(int $userId): ?User
    {
        return User::findOrFail($userId);
    }

    public function get(string $email): ?User
    {
        try {
            return User::whereEmail($email);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}
