<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $email
 * @property User $user
 */
class UserEmail extends Model
{
    /** @use HasFactory<\Database\Factories\UserEmailFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}

