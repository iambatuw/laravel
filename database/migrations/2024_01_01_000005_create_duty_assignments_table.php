<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duty_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duty_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');       // Ogretmen
            $table->foreignId('location_id')->constrained()->onDelete('cascade');   // Nobet yeri
            $table->enum('period', ['morning', 'noon', 'afternoon'])->default('morning'); // Nobet zamani
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['assigned', 'completed', 'absent', 'swapped'])->default('assigned');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['duty_schedule_id', 'user_id', 'period']); // Ayni ogretmen, ayni gun, ayni periyotta tekrar atanamaz
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duty_assignments');
    }
};
