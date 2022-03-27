<?php

declare(strict_types=1);

namespace App\Solution\User\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Solution\User\Services\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    /**
     * Show the profile for current user.
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->getById($id);
        $responseData = null === $user ? [] : $user->toArray();

        return response()->json($responseData);
    }
}
