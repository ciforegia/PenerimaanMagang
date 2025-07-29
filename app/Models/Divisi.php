<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sub_direktorat_id', 'vp', 'nippos'];

    /**
     * Get the sub direktorat that owns the divisi.
     */
    public function subDirektorat()
    {
        return $this->belongsTo(SubDirektorat::class);
    }

    /**
     * Get the internship applications for the divisi.
     */
    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class);
    }

    /**
     * Get the mentors (pembimbing) for the divisi.
     */
    public function mentors()
    {
        return $this->hasMany(User::class)->where('role', 'pembimbing');
    }

    /**
     * Get the pembimbing for the divisi.
     */
    public function pembimbing()
    {
        return $this->hasOne(User::class)->where('role', 'pembimbing');
    }
}
