<?php

namespace Database\Seeders;

use App\Models\DonationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donation_types = ['Tabor', 'Penz', 'Lelkigondozas'];
        foreach ($donation_types as $value) {
            DonationType::create([
                'name' => $value
            ]);
        }
    }
}
