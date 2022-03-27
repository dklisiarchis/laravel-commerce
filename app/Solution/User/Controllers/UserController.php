<?php
declare(strict_types=1);

namespace App\Solution\User\Controllers;

use App\Http\Controllers\Controller;
use App\Solution\User\Services\UserRepository;
use Illuminate\Http\JsonResponse;

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
     * Show the profile for current user
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->getById($id);
        $responseData = $user === null ? [] : $user->toArray();
        return response()->json($responseData);
    }
}
