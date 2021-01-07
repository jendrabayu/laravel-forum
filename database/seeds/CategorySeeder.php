<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Apa itu ?',
            'API',
            'Automated Testing',
            'Berita',
            'Codeigniter 4',
            'Laravel',
            'Windows 10',
            'Tips & Trik',
            'TypeScript',
            'Vs Code'
        ];

        foreach ($categories as $c) {
            Category::create([
                'name' => $c,
                'slug' => Str::slug($c)
            ]);
        }
    }
}
