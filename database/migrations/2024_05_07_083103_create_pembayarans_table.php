<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemesanan');
            $table->string('nama_pengirim')->nullable();
            $table->string('tujuan_bank')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('waktu_pembayaran')->nullable();
            $table->timestamp('batas_waktu_pembayaran');
            $table->enum('status', ['Gagal', 'Belum Bayar', 'Verifikasi', 'Sudah Bayar'])->default('Belum Bayar');
            $table->timestamps();

            $table->foreign('kode_pemesanan')->references('kode')->on('pemesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
