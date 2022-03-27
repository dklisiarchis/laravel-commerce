<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Services;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Solution\Checkout\Models\Cart;
use App\Solution\Checkout\Models\CartItem;
use App\Solution\Stock\Services\StockService;

class CartManagement
{
    /**
     * @var StockService
     */
    private $stockService;

    /**
     * @var RowTotalCalculator
     */
    private $rowCalculator;

    /**
     * @var CartRepository
     */
    private $cartRepository;

    public function __construct(
        ?StockService $stockService = null,
        ?RowTotalCalculator $rowCalculator = null,
        ?CartRepository $cartRepository = null
    ) {
        $this->stockService = $stockService ?? new StockService();
        $this->rowCalculator = $rowCalculator ?? new RowTotalCalculator();
        $this->cartRepository = $cartRepository ?? new CartRepository();
    }

    public function handleAddRequest(Request $request): Cart
    {
        $requestCartId = $request->input('cart_id');
        if (! $requestCartId) {
            $cart = Cart::factory()->make();
            $cart->save();
        } else {
            $cart = $this->cartRepository->getById($requestCartId);
        }

        $qty = $request->input('qty', 1);
        $product = $request->input('product_id');

        return $this->add($cart->id, $product, $qty);
    }

    public function handleUpdateRequest(Request $request): Cart
    {
        $requestCartId = $request->input('cart_id');
        if (! $requestCartId) {
            throw new InvalidArgumentException('Missing cart id');
        }

        $product = $request->input('product_id');
        if (! $product) {
            throw new InvalidArgumentException('Missing product id');
        }

        $qty = $request->input('qty', 0);

        return $this->updateQty($requestCartId, $product, $qty);
    }

    public function add(int $cartId, int $productId, int $qty): Cart
    {
        $this->checkStock($productId, $qty);
        $cart = $this->loadCart($cartId);
        $cartItem = $cart->getCartItem($productId);
        $isExistingItem = ($cartItem instanceof CartItem);

        if ($isExistingItem) {
            $totalQty = (int) $cartItem->qty + $qty;
            $this->checkStock($productId, $totalQty);
            $cartItem->qty = $totalQty;
            $cartItem->row_total = $this->rowCalculator->calculate($productId, $totalQty);
        } else {
            $cartItem = CartItem::factory([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'qty'        => $qty,
                'row_total'  => $this->rowCalculator->calculate($productId, $qty),
            ])->make();
        }

        $cartItem->save();

        return $this->updateTotals($cart->id);
    }

    public function updateQty(int $cartId, int $productId, int $qty): Cart
    {
        $cart = $this->loadCart($cartId);
        $cartItem = $cart->getCartItem($productId);
        if (null === $cartItem) {
            throw new \InvalidArgumentException('Item is not in cart');
        }

        if ($qty > 0) {
            $this->checkStock($productId, $qty);
            $cartItem->qty = $qty;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return $this->updateTotals($cartId);
    }

    public function updateTotals(int $cartId, bool $save = true): Cart
    {
        $cart = $this->loadCart($cartId);
        $cartItems = $cart->getCartItems();

        $baseGrandTotal = 0;
        $totalCount = 0;
        foreach ($cartItems as $cartItem) {
            $baseGrandTotal += $cartItem->row_total;
            $totalCount += $cartItem->qty;
        }

        $cart->grand_total = $baseGrandTotal;
        $cart->base_grand_total = $baseGrandTotal;
        $cart->total_items = $totalCount;
        if ($save) {
            $cart->save();
        }

        return $cart;
    }

    private function loadCart(int $cartId): Cart
    {
        return Cart::where(['id' => $cartId, 'is_active' => true])->firstOr(function () {
            return Cart::factory()->make();
        });
    }

    private function checkStock(int $productId, int $qty): void
    {
        if (! $this->stockService->hasEnoughStock($productId, $qty)) {
            throw new \InvalidArgumentException('Requested quantity is not available');
        }
    }
}
