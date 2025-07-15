<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the sub direktorats for the direktorat.
     */
    public function subDirektorats()
    {
        return $this->hasMany(SubDirektorat::class);
    }
}
