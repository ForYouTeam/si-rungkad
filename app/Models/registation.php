<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registation extends Model
{
    use HasFactory;
    protected $table = 'registation';
    protected $fillable = [
        'no_registrasi',
        'medicalcard_id',
        'poly_id',
        'tgl_registrasi',
        'attachment_id',
        'qr_code'
    ];

    public function scopejoinList($query)
    {
        return $query ->leftJoin('medicalcard as model_a', 'registation.medicalcard_id', '=', 'model_a.id')
        ->leftJoin('poly as model_b', 'registation.poly_id', '=', 'model_b.id')
        ->leftJoin('attachment as model_c', 'registation.attachment_id', '=', 'model_c.id')
        ->select(
            'registation.id',
            'registation.no_registrasi',
            'model_a.no_rm as rekammedis',
            'model_b.nama as nama_poly',
            'registation.tgl_registrasi',
            'model_c.foto_ktp as ktp',
            'model_c.foto_kartu_berobat as kb',
            'registation.qr_code',
        );   
    }
}
