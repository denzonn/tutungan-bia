<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_article_id',
        'content',
        'image',
        'status',
        'click_count',
        'contributor_id',
        'editor_id',
    ];

    public function categoryArticle()
    {
        return $this->belongsTo(CategoryArticle::class, 'category_article_id');
    }

    public function articleContributor()
    {
        return $this->belongsTo(User::class, 'contributor_id');
    }

    public function articleEditor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
