<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPageRecords = [
            ['id' => 1, 'title' => 'About Us', 'description' => 'about-us', 'url' => 'about-us',  'meta_title' => 'About Us', 'meta_description' => 'About Us', 'meta_keywords' => 'About Us', 'status' => 1
            ],
            
            ['id' => 2, 'title' => 'Contact Us', 'description' => 'contact-us', 'url' => 'contact-us',  'meta_title' => 'Contact Us', 'meta_description' => 'Contact Us', 'meta_keywords' => 'Contact Us', 'status' => 0
        
            ],


        ];

        CmsPage::insert($cmsPageRecords);
    }
}
