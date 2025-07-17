<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'file_path',
        'submission_file_path',
        'grade',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'deadline' => 'date',
    ];

    /**
     * Get the user that owns the assignment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
