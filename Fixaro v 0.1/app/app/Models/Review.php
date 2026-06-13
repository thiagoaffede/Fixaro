<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['problem_id', 'client_id', 'professional_id', 'rating', 'comment'];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
