<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_profile',
        'logo',
        'sosial_media_1',
        'sosial_media_2',
        'sosial_media_3',
    ];
}
