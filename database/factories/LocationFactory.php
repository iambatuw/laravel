<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $locations = [
            ['name' => 'Ana Bahçe', 'floor' => 'Zemin Kat', 'description' => 'Okulun ana bahçesi ve oyun alanı'],
            ['name' => 'Arka Bahçe', 'floor' => 'Zemin Kat', 'description' => 'Arka bahçe ve spor alanı'],
            ['name' => '1. Kat Koridor', 'floor' => '1. Kat', 'description' => 'Birinci kat ana koridoru'],
            ['name' => '2. Kat Koridor', 'floor' => '2. Kat', 'description' => 'İkinci kat ana koridoru'],
            ['name' => '3. Kat Koridor', 'floor' => '3. Kat', 'description' => 'Üçüncü kat ana koridoru'],
            ['name' => 'Kantin Önü', 'floor' => 'Zemin Kat', 'description' => 'Kantin önü ve bekleme alanı'],
            ['name' => 'Yemekhane', 'floor' => 'Zemin Kat', 'description' => 'Yemekhane alanı'],
            ['name' => 'Spor Salonu', 'floor' => 'Zemin Kat', 'description' => 'Kapalı spor salonu'],
            ['name' => 'Kütüphane Önü', 'floor' => '1. Kat', 'description' => 'Kütüphane girişi ve okuma alanı'],
            ['name' => 'Laboratuvar Koridoru', 'floor' => '2. Kat', 'description' => 'Fen laboratuvarları koridoru'],
        ];

        $location = fake()->randomElement($locations);

        return [
            'name' => $location['name'],
            'floor' => $location['floor'],
            'description' => $location['description'],
            'capacity' => fake()->numberBetween(1, 3),
            'is_active' => true,
        ];
    }
}
