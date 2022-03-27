<?php

declare(strict_types=1);

namespace App\Solution\Checkout\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Solution\User\Models\User;
use App\Http\Controllers\Controller;
use App\Solution\User\Models\Address;
use App\Solution\Checkout\Models\Cart;
use App\Solution\User\Services\AccountManagement;
use App\Solution\Checkout\Services\OrderManagement;

class CheckoutController extends Controller
{
    /**
     * @var AccountManagement
     */
    private $accountManagement;

    /**
     * @var OrderManagement
     */
    private $orderManagement;

    public function __construct(
        AccountManagement $accountManagement,
        OrderManagement $orderManagement
    ) {
        $this->accountManagement = $accountManagement;
        $this->orderManagement = $orderManagement;
    }

    /**
     * @throws \Throwable
     */
    public function placeOrder(Request $request): JsonResponse
    {
        $cart = Cart::findOrFail($request->input('cart_id'));
        $address = $this->extractAddress($request);
        $customer = $this->extractCustomer($request);
        $customerEmail = null === $customer
            ? $request->input('email')
            : $customer->email;

        $order = $this->orderManagement->placeOrder(
            $cart,
            $address,
            $customerEmail,
            $customer,
            $request->input('coupon_code')
        );

        return response()->json($order->toArray());
    }

    private function extractCustomer(Request $request): ?User
    {
        $requestEmail = $request->input('email');
        if (! $requestEmail) {
            throw new \InvalidArgumentException('Email is required');
        }

        $isAvailable = $this->accountManagement->isEmailAvailable($requestEmail);
        if (! $isAvailable) {
            throw new \InvalidArgumentException('Invalid email address');
        }

        if (! $request->boolean('create_account')) {
            return null;
        }

        /** @var User $newUser */
        $newUser = User::factory([
            'name'     => sprintf('%s %s', $request->input('first_name'), $request->input('last_name')),
            'email'    => $requestEmail,
            'password' => $request->input('password'),
        ])->make();
        $newUser->save();

        return $newUser;
    }

    private function extractAddress(Request $request): Address
    {
        $addressId = $request->input('address_id');
        if ($addressId) {
            return Address::findOrFail($addressId);
        }

        /** @var Address $address */
        $address = Address::factory([
            'user_id'          => $request->input('user_id'),
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'country_id'       => $request->input('country_id'),
            'street'           => $request->input('street'),
            'addition'         => $request->input('addition'),
            'postcode'         => $request->input('postcode'),
            'telephone'        => $request->input('telephone'),
            'default_shipping' => $request->boolean('default_shipping'),
            'default_billing'  => $request->boolean('default_billing'),
        ])->make();

        $address->save();

        return $address;
    }
}
