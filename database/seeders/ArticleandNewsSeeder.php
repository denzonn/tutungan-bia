<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleandNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            'title' => 'First Article',
            'slug' => 'this-slug',
            'content' => 'This is the content of the first article.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
