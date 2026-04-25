<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duty_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');                    // Nobet tarihi
            $table->string('day_of_week');          // Pazartesi, Salı, Çarşamba, Perşembe, Cuma
            $table->string('title')->nullable();     // Orn: "3 Mart 2026 Nobet Cizelgesi"
            $table->text('notes')->nullable();        // Ek notlar
            $table->enum('status', ['draft', 'published', 'completed'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            $table->unique('date'); // Her gun icin tek cizelge
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duty_schedules');
    }
};
