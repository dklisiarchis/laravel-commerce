<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Controllers;

use App\Http\Controllers\Controller;
use App\Solution\Checkout\Models\Cart;
use App\Solution\Checkout\Services\CartManagement;
use App\Solution\Checkout\Services\CartRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * @param int $cartId
     * @return JsonResponse
     */
    public function show(int $cartId): JsonResponse
    {
        $cart = $this->cartRepository->getById($cartId);
        return response()->json($cart->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $cart = $this->cartManagement->handleAddRequest($request);
        return response()->json($cart->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $cart = $this->cartManagement->handleUpdateRequest($request);
        return response()->json($cart->toArray());
    }
}
