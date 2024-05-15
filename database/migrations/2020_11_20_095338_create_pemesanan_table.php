<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_penumpang');
            $table->string('no_telepon');
            $table->string('email');
            $table->text('alamat');
            $table->string('kursi')->nullable();
            $table->timestamp('waktu');
            $table->integer('total');
            $table->enum('status', ['Berhasil', 'Belum Bayar', 'Verifikasi', 'Gagal'])->default('Belum Bayar');

            $table->unsignedBigInteger('rute_id');
            $table->unsignedBigInteger('pemesan_id');
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->timestamps();

            $table->foreign('rute_id')->references('id')->on('rute');
            $table->foreign('pemesan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
}
