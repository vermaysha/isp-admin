<?php

namespace Database\Seeders;

use App\Enums\ResellerType;
use App\Models\Address;
use App\Models\Office;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::factory(1, [
            'username' => 'gmdp_solo',
        ])->create() as $owner) {
            $owner->assignRole(Role::RESELLER_OWNER);

            $reseller = Reseller::create(Reseller::factory(1, [
                'name' => 'GMDP Surakarta',
                'user_id' => $owner->id,
                'type' => ResellerType::DIRECT,
            ])->makeOne()->toArray());

            $reseller->employees()->attach($owner->id);

            Office::create([
                'name' => 'GMDP Surakarta',
                'address_id' => Address::factory(null, [
                    'village_id' => 35138,
                ])->create()->id,
                'reseller_id' => $reseller->id,
            ]);
        }
    }
}
