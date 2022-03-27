<?php
declare(strict_types=1);

namespace App\Solution\User\Services;

use App\Solution\User\Models\Address;
use App\Solution\User\Models\User;

class AccountManagement
{

    /**
     * @param User $user
     * @param Address[] $addresses
     * @return bool
     */
    public function register(User $user, array $addresses): bool
    {
        return true;
    }

    public function isEmailAvailable(string $email): bool
    {
        return User::where('email', $email)->count() === 0;
    }
}
