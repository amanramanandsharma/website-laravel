<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            'name' => "User1",
            'email' => "user1@website.com",
            'password' => bcrypt('secret')
        ],[
            'name' => "User2",
            'email' => "user2@website.com",
            'password' => bcrypt('secret')
        ],[
            'name' => "User3",
            'email' => "user3@website.com",
            'password' => bcrypt('secret')
        ]
        ]);

        DB::table('websites')->insert([[
            'name' => "website1",
            'url' => "www.website1.com",
        ],[
            'name' => "website2",
            'url' => "www.website2.com",
        ],[
            'name' => "website3",
            'url' => "www.website3.com",
        ]
        ]);

        DB::table('posts')->insert([[
            'title' => "Post 1 - Website 1",
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus placerat tristique neque et rutrum. Vivamus feugiat justo sed turpis dignissim, sed malesuada arcu pulvinar.",
            'website_id' => 1,
        ],
        [
            'title' => "Post 2 - Website 1",
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus placerat tristique neque et rutrum. Vivamus feugiat justo sed turpis dignissim, sed malesuada arcu pulvinar.",
            'website_id' => 1,
        ],
        [
            'title' => "Post 1 - Website 2",
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus placerat tristique neque et rutrum. Vivamus feugiat justo sed turpis dignissim, sed malesuada arcu pulvinar.",
            'website_id' => 2,
        ],
        [
            'title' => "Post 2 - Website 2",
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus placerat tristique neque et rutrum. Vivamus feugiat justo sed turpis dignissim, sed malesuada arcu pulvinar.",
            'website_id' => 2,
        ]
        ]);

        DB::table('website_users')->insert([[
            'website_id' => 1,
            'user_id' => 1
        ],[
            'website_id' => 1,
            'user_id' => 2
        ],
        [
            'website_id' => 2,
            'user_id' => 1
        ],[
            'website_id' => 2,
            'user_id' => 2
        ],[
            'website_id' => 2,
            'user_id' => 3
        ],
        [
            'website_id' => 3,
            'user_id' => 1
        ],[
            'website_id' => 3,
            'user_id' => 2
        ],[
            'website_id' => 3,
            'user_id' => 3
        ],
        ]);

       
    }
}
