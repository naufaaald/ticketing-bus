<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rute()
    {
        return $this->belongsTo('App\Models\Rute', 'rute_id');
    }

    public function penumpang()
    {
        return $this->belongsTo('App\Models\User', 'pemesan_id');
    }

    public function petugas()
    {
        return $this->belongsTo('App\Models\User', 'petugas_id');
    }

    public function pembayaran()
    {
        return $this->hasOne('App\Models\Pembayaran', 'kode');
    }

    protected $table = 'pemesanan';
}
