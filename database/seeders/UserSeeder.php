<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Solution\User\Models\User;
use App\Solution\User\Models\Address;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; ++$i) {
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
