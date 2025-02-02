<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'articles_id',
        'ip_address',
        'visit_date',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
