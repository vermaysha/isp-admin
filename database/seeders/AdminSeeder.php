<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1, [
            'username' => 'admin',
        ])->create()->each(function (User $user) {
            $user->assignRole(Role::ADMIN);

            Admin::create([
                'user_id' => $user->id,
                'office_location' => 'Solo',
            ]);
        });
    }
}
