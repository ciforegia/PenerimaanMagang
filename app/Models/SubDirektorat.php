<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDirektorat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'direktorat_id'];

    /**
     * Get the direktorat that owns the sub direktorat.
     */
    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class);
    }

    /**
     * Get the divisis for the sub direktorat.
     */
    public function divisis()
    {
        return $this->hasMany(Divisi::class);
    }
}
