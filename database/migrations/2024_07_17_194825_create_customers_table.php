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
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Membuat kolom id dengan tipe bigIncrements
            $table->string('foto'); // Membuat kolom foto dengan tipe string
            $table->string('nama'); // Membuat kolom nama dengan tipe string
            $table->string('email'); // Membuat kolom email dengan tipe string
            $table->string('password'); // Membuat kolom password dengan tipe string
            $table->string('nomor_hp'); // Membuat kolom nomor_hp dengan tipe string
            $table->longText('alamat'); // Membuat kolom alamat dengan tipe longText
            $table->timestamps(); // Membuat kolom created_at dan updated_at dengan tipe timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
