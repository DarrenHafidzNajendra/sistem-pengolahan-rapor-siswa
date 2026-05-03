<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengampu_id')->constrained('pengampu')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');

            // Pengetahuan
            $table->decimal('tugas', 5, 2)->nullable();
            $table->decimal('ulangan_harian', 5, 2)->nullable();
            $table->decimal('uts', 5, 2)->nullable();
            $table->decimal('uas', 5, 2)->nullable();

            // Keterampilan
            $table->decimal('praktik', 5, 2)->nullable();
            $table->decimal('proyek', 5, 2)->nullable();
            $table->decimal('portofolio', 5, 2)->nullable();

            // Sikap
            $table->enum('sikap_spiritual', ['A', 'B', 'C', 'D'])->nullable();
            $table->enum('sikap_sosial', ['A', 'B', 'C', 'D'])->nullable();

            // Catatan
            $table->text('catatan_guru')->nullable();

            $table->timestamps();

            $table->unique(['pengampu_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
