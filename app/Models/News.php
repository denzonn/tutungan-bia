<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'publish_date',
        'status',
        'click_count',
        'contributor_id',
        'editor_id',
    ];

    public function contributor()
    {
        return $this->belongsTo(User::class, 'contributor_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
