<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsNotification extends Model
{
    use HasFactory;

    protected $table = 'sms_notifications';

    protected $fillable = [
      'code',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
