<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('kegiatan', function (Blueprint $table) {
      $table->id();
      $table->string('format_no')->nullable();
      $table->string('nama_kegiatan')->nullable();
      $table->string('slug')->nullable();
      $table->string('penyelenggara')->nullable();
      $table->string('tempat')->nullable();
      $table->date('tgl_mulai')->nullable();
      $table->date('tgl_selesai')->nullable();
      $table->integer('jumlah_jam')->nullable();
      $table->string('tgl_sertifikat')->nullable();
      $table->string('pejabat')->nullable();
      $table->string('jabatan')->nullable();
      $table->string('nip')->nullable();
      $table->string('nik')->nullable();
      $table->text('template')->nullable();
      $table->integer('user_id')->nullable();

      $table->timestamps();
      $table->index('user_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kegiatan');
  }
};
