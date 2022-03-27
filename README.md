# LaravelCommerce
A small eCommerce application built with Laravel.

Features:
 - Get product list (GET|HEAD @ /api/catalog)
 - Add product to cart (POST @ /api/cart/add) 
 - Update qty in cart/remove from cart (POST @ /api/cart/update)
 - Get/show cart (GET|HEAD @ /api/cart/{id})
 - Place order (POST @ /api/order/place).
 - Coupon functionality.
 - Option to register on checkout.
 - 15 minutes after the first order, a 5$ coupon is generated and sent to the customer's email address

Todos:
- Add tests.
