<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $branches = [
            'Matematik', 'Türkçe', 'Fizik', 'Kimya', 'Biyoloji',
            'Tarih', 'Coğrafya', 'İngilizce', 'Almanca', 'Müzik',
            'Beden Eğitimi', 'Görsel Sanatlar', 'Bilişim Teknolojileri',
            'Din Kültürü', 'Felsefe', 'Edebiyat',
        ];

        return [
            'name' => fake('tr_TR')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => fake('tr_TR')->phoneNumber(),
            'branch' => fake()->randomElement($branches),
            'avatar' => null,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'branch' => 'Yönetim',
        ]);
    }

    public function teacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'teacher',
        ]);
    }
}
