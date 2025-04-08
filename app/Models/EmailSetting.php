<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $fillable = [
        'smtp_host',
        'smtp_port',
        'encryption_type',
        'smtp_username',
        'smtp_password',
        'from_email_address',
        'from_name',
    ];
}
