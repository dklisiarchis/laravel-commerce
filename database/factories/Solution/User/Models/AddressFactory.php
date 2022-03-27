<?php

namespace Database\Factories\Solution\User\Models;

use App\Solution\User\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{

    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'country_id' => $this->faker->countryCode(),
            'street' => $this->faker->unique()->streetAddress(),
            'addition' => sprintf('%s%s', strtoupper($this->faker->randomLetter()), $this->faker->randomNumber(1)),
            'postcode' => $this->faker->postcode(),
            'telephone' => $this->faker->phoneNumber(),
            'default_shipping' => false,
            'default_billing' => false
        ];
    }
}
