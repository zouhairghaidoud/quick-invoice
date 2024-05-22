<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::query()->create([
            'name' => 'Zouhair Ghaidoud',
            'email' => 'zouhair@ghaidoud.com',
            'password' => Hash::make('password'),
        ]);

        \App\Models\Invoice::factory(5)->create();
        \App\Models\InvoiceItem::factory(50)->create();
    }
}
