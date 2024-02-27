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
    Schema::create('pendaftaran', function (Blueprint $table) {
      $table->id();
      $table->string('nama_peserta');
      $table->string('no_peserta')->unique();
      $table->string('asal_instansi');
      $table->string('no_tlp');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pendaftaran');
  }
};
