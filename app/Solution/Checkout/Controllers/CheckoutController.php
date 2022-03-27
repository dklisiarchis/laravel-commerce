<?php
declare(strict_types=1);

namespace App\Solution\Checkout\Controllers;

use App\Http\Controllers\Controller;
use App\Solution\Checkout\Models\Cart;
use App\Solution\Checkout\Services\OrderManagement;
use App\Solution\User\Models\Address;
use App\Solution\User\Models\User;
use App\Solution\User\Services\AccountManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * @param AccountManagement $accountManagement
     * @param OrderManagement $orderManagement
     */
    public function __construct(
        AccountManagement $accountManagement,
        OrderManagement $orderManagement
    ) {
        $this->accountManagement = $accountManagement;
        $this->orderManagement = $orderManagement;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function placeOrder(Request $request): JsonResponse
    {
        $cart = Cart::findOrFail($request->input('cart_id'));
        $address = $this->extractAddress($request);
        $customer = $this->extractCustomer($request);
        $customerEmail = $customer === null
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

    /**
     * @param Request $request
     * @return User|null
     */
    private function extractCustomer(Request $request): ?User
    {
        $requestEmail = $request->input('email');
        if (!$requestEmail) {
            throw new \InvalidArgumentException('Email is required');
        }

        $isAvailable = $this->accountManagement->isEmailAvailable($requestEmail);
        if (!$isAvailable) {
            throw new \InvalidArgumentException('Invalid email address');
        }

        if (!$request->boolean('create_account')) {
            return null;
        }

        /** @var User $newUser */
        $newUser = User::factory([
            'name' => $request->input('name'),
            'email' => $requestEmail,
            'password' => $request->input('password'),
        ])->make()->save();

        return $newUser;
    }

    /**
     * @param Request $request
     * @return Address
     */
    private function extractAddress(Request $request): Address
    {
        $addressId = $request->input('address_id');
        if ($addressId) {
            return Address::findOrFail($addressId);
        }

        /** @var Address $address */
        $address = Address::factory([
            'user_id' => $request->input('user_id'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'country_id' => $request->input('country_id'),
            'street' => $request->input('street'),
            'addition' => $request->input('addition'),
            'postcode' => $request->input('postcode'),
            'telephone' => $request->input('telephone'),
            'default_shipping' => $request->boolean('default_shipping'),
            'default_billing' => $request->boolean('default_billing'),
        ])->make();

        $address->save();
        return $address;
    }
}
