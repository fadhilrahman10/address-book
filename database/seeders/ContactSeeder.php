<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Contact::create([
                'name' => 'seeder ' . $i,
                'phone' => '0123456789' . $i,
                'address' => 'seeder address ' . $i,
            ]);
        }
    }
}
