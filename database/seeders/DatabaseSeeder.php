<?php

namespace Database\Seeders;

use App\Models\DutyAssignment;
use App\Models\DutySchedule;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. Admin Kullanıcısı =====
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '0532 123 45 67',
                'branch' => 'Yönetim',
                'email_verified_at' => now(),
            ]
        );

        // ===== 2. Öğretmenler (20 adet) =====
        $teacherData = [
            ['name' => 'Fatma Demir', 'branch' => 'Matematik', 'email' => 'fatma.demir@nobetci.com'],
            ['name' => 'Mehmet Kaya', 'branch' => 'Fizik', 'email' => 'mehmet.kaya@nobetci.com'],
            ['name' => 'Ayşe Çelik', 'branch' => 'Türkçe', 'email' => 'ayse.celik@nobetci.com'],
            ['name' => 'Mustafa Öztürk', 'branch' => 'Tarih', 'email' => 'mustafa.ozturk@nobetci.com'],
            ['name' => 'Zeynep Yıldız', 'branch' => 'İngilizce', 'email' => 'zeynep.yildiz@nobetci.com'],
            ['name' => 'Ali Aksoy', 'branch' => 'Kimya', 'email' => 'ali.aksoy@nobetci.com'],
            ['name' => 'Elif Koç', 'branch' => 'Biyoloji', 'email' => 'elif.koc@nobetci.com'],
            ['name' => 'Hasan Şahin', 'branch' => 'Coğrafya', 'email' => 'hasan.sahin@nobetci.com'],
            ['name' => 'Merve Aydın', 'branch' => 'Edebiyat', 'email' => 'merve.aydin@nobetci.com'],
            ['name' => 'Emre Güneş', 'branch' => 'Beden Eğitimi', 'email' => 'emre.gunes@nobetci.com'],
            ['name' => 'Seda Arslan', 'branch' => 'Müzik', 'email' => 'seda.arslan@nobetci.com'],
            ['name' => 'Burak Doğan', 'branch' => 'Bilişim Teknolojileri', 'email' => 'burak.dogan@nobetci.com'],
            ['name' => 'Derya Polat', 'branch' => 'Görsel Sanatlar', 'email' => 'derya.polat@nobetci.com'],
            ['name' => 'Oğuz Erdoğan', 'branch' => 'Matematik', 'email' => 'oguz.erdogan@nobetci.com'],
            ['name' => 'Gamze Kılıç', 'branch' => 'Fizik', 'email' => 'gamze.kilic@nobetci.com'],
            ['name' => 'Serkan Yılmaz', 'branch' => 'Almanca', 'email' => 'serkan.yilmaz@nobetci.com'],
            ['name' => 'Nur Başaran', 'branch' => 'Din Kültürü', 'email' => 'nur.basaran@nobetci.com'],
            ['name' => 'Kemal Tuncer', 'branch' => 'Felsefe', 'email' => 'kemal.tuncer@nobetci.com'],
            ['name' => 'İrem Çakır', 'branch' => 'Türkçe', 'email' => 'irem.cakir@nobetci.com'],
            ['name' => 'Volkan Ateş', 'branch' => 'Tarih', 'email' => 'volkan.ates@nobetci.com'],
        ];

        $teachers = [];
        foreach ($teacherData as $data) {
            $teachers[] = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'phone' => '05' . rand(30, 59) . ' ' . rand(100, 999) . ' ' . rand(10, 99) . ' ' . rand(10, 99),
                'branch' => $data['branch'],
                'email_verified_at' => now(),
            ]);
        }

        // ===== 3. Nöbet Yerleri (10 adet) =====
        $locationData = [
            ['name' => 'Ana Bahçe', 'floor' => 'Zemin Kat', 'description' => 'Okulun ana bahçesi ve oyun alanı', 'capacity' => 2],
            ['name' => 'Arka Bahçe', 'floor' => 'Zemin Kat', 'description' => 'Arka bahçe ve spor alanı', 'capacity' => 1],
            ['name' => '1. Kat Koridor', 'floor' => '1. Kat', 'description' => 'Birinci kat ana koridoru', 'capacity' => 1],
            ['name' => '2. Kat Koridor', 'floor' => '2. Kat', 'description' => 'İkinci kat ana koridoru', 'capacity' => 1],
            ['name' => '3. Kat Koridor', 'floor' => '3. Kat', 'description' => 'Üçüncü kat ana koridoru', 'capacity' => 1],
            ['name' => 'Kantin Önü', 'floor' => 'Zemin Kat', 'description' => 'Kantin önü ve bekleme alanı', 'capacity' => 2],
            ['name' => 'Yemekhane', 'floor' => 'Zemin Kat', 'description' => 'Yemekhane alanı', 'capacity' => 2],
            ['name' => 'Spor Salonu', 'floor' => 'Zemin Kat', 'description' => 'Kapalı spor salonu', 'capacity' => 1],
            ['name' => 'Kütüphane Önü', 'floor' => '1. Kat', 'description' => 'Kütüphane girişi ve okuma alanı', 'capacity' => 1],
            ['name' => 'Laboratuvar Koridoru', 'floor' => '2. Kat', 'description' => 'Fen laboratuvarları koridoru', 'capacity' => 1],
        ];

        $locations = [];
        foreach ($locationData as $data) {
            $locations[] = Location::create($data);
        }

        // ===== 4. Nöbet Çizelgeleri (Bu hafta için) =====
        $dayNames = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma'];
        $periods = ['morning', 'noon', 'afternoon'];

        $startOfWeek = Carbon::now()->startOfWeek();

        for ($i = 0; $i < 5; $i++) {
            $date = $startOfWeek->copy()->addDays($i);

            $schedule = DutySchedule::create([
                'date' => $date,
                'day_of_week' => $dayNames[$i],
                'title' => $date->format('d.m.Y') . ' ' . $dayNames[$i] . ' Nöbet Çizelgesi',
                'notes' => null,
                'status' => $date->lt(today()) ? 'completed' : ($date->eq(today()) ? 'published' : 'draft'),
                'created_by' => $admin->id,
            ]);

            // Her gün için rastgele atamalar
            $shuffledTeachers = collect($teachers)->shuffle();
            $teacherIndex = 0;

            foreach ($periods as $period) {
                // Her periyotta 3-4 lokasyona atama yap
                $selectedLocations = collect($locations)->shuffle()->take(rand(3, 5));

                foreach ($selectedLocations as $location) {
                    if ($teacherIndex >= count($teachers)) {
                        $teacherIndex = 0;
                        $shuffledTeachers = collect($teachers)->shuffle();
                    }

                    $startTime = match ($period) {
                        'morning' => '08:00',
                        'noon' => '11:30',
                        'afternoon' => '13:30',
                    };

                    $endTime = match ($period) {
                        'morning' => '11:30',
                        'noon' => '13:30',
                        'afternoon' => '16:00',
                    };

                    DutyAssignment::create([
                        'duty_schedule_id' => $schedule->id,
                        'user_id' => $shuffledTeachers[$teacherIndex]->id,
                        'location_id' => $location->id,
                        'period' => $period,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'status' => $date->lt(today()) ? 'completed' : 'assigned',
                    ]);

                    $teacherIndex++;
                }
            }
        }
    }
}
