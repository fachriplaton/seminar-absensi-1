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
    Schema::create('peserta', function (Blueprint $table) {
      $table->id();
      $table->string('nama_peserta')->nullable();
      $table->string('no_peserta')->nullable();
      $table->string('asal_instansi')->nullable();
      $table->string('no_urut')->nullable();
      $table->string('kegiatan_id')->nullable();
      $table->string('no_tlp')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('peserta');
  }
};
