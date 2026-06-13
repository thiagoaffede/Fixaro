<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Message;

#[Fillable(['name', 'surname', 'email', 'phone', 'role', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function professional()
    {
        return $this->hasOne(Professional::class);
    }

    public function problems()
    {
        return $this->hasMany(Problem::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function unreadMessagesCount()
    {
        return Message::whereHas('response', function ($query) {
            $query->where(function ($sub) {
                $sub->whereHas('professional', function ($q) {
                    $q->where('user_id', $this->id);
                })->orWhereHas('problem', function ($q) {
                    $q->where('user_id', $this->id);
                });
            });
        })
        ->where('sender_id', '!=', $this->id)
        ->where('is_read', false)
        ->count();
    }
}
