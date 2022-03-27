<?php

declare(strict_types=1);

namespace App\Solution\User\Services;

use App\Solution\User\Models\User;
use App\Solution\User\Models\Address;

class AccountManagement
{
    /**
     * @param Address[] $addresses
     */
    public function register(User $user, array $addresses): bool
    {
        return true;
    }

    public function isEmailAvailable(string $email): bool
    {
        return 0 === User::where('email', $email)->count();
    }
}
