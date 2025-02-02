<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsVisitors extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'ip_address',
        'visit_date',
    ];

    public function news(){
        return $this->belongsTo(News::class);
    }
}
