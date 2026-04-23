<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nim');
        $table->string('nama_paket');
        $table->string('status')->default('pending');
        $table->timestamps();
    });
}
};
