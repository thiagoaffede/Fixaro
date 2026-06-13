<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['problem_id', 'professional_id', 'price_estimate', 'time_estimate', 'message', 'status'];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Check if a user is involved in this response (either the professional or the client).
     */
    public function involvesUser($userId)
    {
        return ($this->professional?->user_id === $userId) || ($this->problem?->user_id === $userId);
    }

    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
}
