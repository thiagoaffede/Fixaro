<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['response_id', 'sender_id', 'message', 'is_read'];

    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
