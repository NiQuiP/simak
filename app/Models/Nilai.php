<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'krs_id',
        'nilai_angka',
        'nilai_huruf',
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id');
    }

    public static function konversiNilai(?float $angka): ?string
    {
        if ($angka === null) {
            return null;
        }

        if ($angka >= 85) return 'A';
        if ($angka >= 70) return 'B';
        if ($angka >= 55) return 'C';
        if ($angka >= 40) return 'D';
        return 'E';
    }
}

