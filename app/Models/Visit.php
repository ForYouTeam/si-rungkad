<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visit extends Model
{
    use HasFactory;
    protected $table = "visit";

    protected $fillable = [
        'profile_id',
        'no_rm',
        'no_registrasi'
    ];

    public function getProfileByVisit()
    {
        return DB::table('visit as v')
        ->leftJoin('profile as p', 'v.profile_id', '=', 'p.id')
        ->select(
            'v.*',
            'p.nama',
            'p.no_rm as rekamedik'
        );
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
