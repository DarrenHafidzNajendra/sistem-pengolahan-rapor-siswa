<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            // Tambahkan index biasa dulu agar FK tidak error saat unique index dihapus
            $table->index('kelas_siswa_id', 'nilai_kelas_siswa_id_idx');
            
            // Hapus index unik lama
            // Di MySQL, jika index unik digunakan untuk FK, kita harus punya index pengganti
            $table->dropUnique('uq_nilai_siswa');
            
            // Tambahkan index unik baru yang mencakup komponen_nilai_id
            $table->unique(['kelas_siswa_id', 'pengampu_id', 'jenis_nilai', 'komponen_nilai_id'], 'uq_nilai_siswa_new');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropUnique('uq_nilai_siswa_new');
            $table->unique(['kelas_siswa_id', 'pengampu_id', 'jenis_nilai'], 'uq_nilai_siswa');
            $table->dropIndex('nilai_kelas_siswa_id_idx');
        });
    }
};
