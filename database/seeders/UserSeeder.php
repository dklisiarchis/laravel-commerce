<?php

namespace Database\Seeders;

use App\Solution\User\Models\Address;
use App\Solution\User\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();
            Address::factory(['default_shipping' => true])
                ->for($user)
                ->create();
            Address::factory(['default_billing' => true])
                ->for($user)
                ->create();
        }
    }
}
