<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Solution\Checkout\Services\CartManagement;
use App\Solution\Checkout\Services\CartRepository;

class CartController extends Controller
{
    /**
     * @var CartManagement|null
     */
    private $cartManagement;

    /**
     * @var
     */
    private $cartRepository;

    public function __construct(
        ?CartManagement $cartManagement = null,
        ?CartRepository $cartRepository = null
    ) {
        $this->cartManagement = $cartManagement;
        $this->cartRepository = $cartRepository;
    }

    public function show(int $cartId): JsonResponse
    {
        $cart = $this->cartRepository->getById($cartId);

        return response()->json($cart->toArray());
    }

    public function add(Request $request): JsonResponse
    {
        $cart = $this->cartManagement->handleAddRequest($request);

        return response()->json($cart->toArray());
    }

    public function update(Request $request): JsonResponse
    {
        $cart = $this->cartManagement->handleUpdateRequest($request);

        return response()->json($cart->toArray());
    }
}
