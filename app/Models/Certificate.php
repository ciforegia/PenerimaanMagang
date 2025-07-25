<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_path',
        'issued_at',
        'internship_application_id',
        'nomor_sertifikat',
        'predikat',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    /**
     * Get the user that owns the certificate.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function internshipApplication()
    {
        return $this->belongsTo(InternshipApplication::class);
    }
}
