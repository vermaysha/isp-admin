<?php

namespace Database\Seeders;

use App\Enums\ResellerType;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = fake('id_ID');

        foreach (User::factory(1, ['username' => 'reseller_owner'])->create() as $owner) {
            $owner->assignRole(Role::RESELLER_OWNER);

            $reseller = Reseller::create(Reseller::factory(1, [
                'user_id' => $owner->id,
                'type' => ResellerType::INDIRECT,
            ])->makeOne()->toArray());

            $reseller->employees()->attach($owner->id);

            $resellerAdmin = User::factory(1, [
                'username' => 'reseller_admin',
                'created_at' => $reseller->created_at,
                'updated_at' => $reseller->updated_at,
            ])->create();
            $dummyResellerAdmin = User::factory(mt_rand(1, 2), [
                'created_at' => $reseller->created_at,
                'updated_at' => $reseller->updated_at,
            ])->create();
            foreach ($resellerAdmin->merge($dummyResellerAdmin) as $admin) {
                $admin->assignRole(Role::RESELLER_ADMIN);
                $reseller->employees()->attach($admin->id);
            }

            $resellerTeknisi = User::factory(1, [
                'username' => 'reseller_teknisi',
                'created_at' => $reseller->created_at,
                'updated_at' => $reseller->updated_at,
            ])->create();
            $dummyResellerTeknisi = User::factory(mt_rand(8, 12), [
                'created_at' => $reseller->created_at,
                'updated_at' => $reseller->updated_at,
            ])->create();
            foreach ($resellerTeknisi->merge($dummyResellerTeknisi) as $teknisi) {
                $teknisi->assignRole(Role::RESELLER_TECHNICIAN);
                $reseller->employees()->attach($teknisi->id);
            }
        }
    }
}
