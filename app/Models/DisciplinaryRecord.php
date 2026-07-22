<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'author_id',
        'title',
        'description',
        'type',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
