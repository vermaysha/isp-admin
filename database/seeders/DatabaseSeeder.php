<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            \Vermaysha\Wilayah\Seeds\DatabaseSeeder::class,
            AdminSeeder::class,
        ]);

        if (! app()->environment('production')) {
            $file = Http::get('https://placehold.jp/ffffff/000000/200x300.jpg?text=Contoh%20File%20KTP');
            Storage::disk('ktp')->put('example.jpg', $file->body());

            $file = Http::get('https://placehold.jp/ffffff/000000/200x300.jpg?text=Contoh%20File%20Kontrak');
            Storage::disk('contracts')->put('example.jpg', $file->body());

            $this->call([
                ResellerSeeder::class,
                PlanSeeder::class,
                ClientSeeder::class,
                BillSeeder::class,
                WalletSeeder::class,
                InvoicePDFSeeder::class,
            ]);
        }
    }
}
