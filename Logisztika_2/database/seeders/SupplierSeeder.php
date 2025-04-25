<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory([
            'name' => 'Okos Kft.',
            'contact_email' => 'support@okos.com',
            'contact_phone' => '+3630654321'
        ]);
    }
}
