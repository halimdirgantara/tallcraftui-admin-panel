<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'via_app',
        'via_email',
        'via_telegram',
        'via_whatsapp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 