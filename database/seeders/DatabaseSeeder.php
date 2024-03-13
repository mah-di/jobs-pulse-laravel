<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $result = \App\Models\User::factory()->create([
            'email' => 'admin@jobspulse.com',
            'role' => 'Site Admin',
            'password' => '123',
            'otp' => 0,
            'emailVerifiedAt' => now(),
            'isSuperUser' => true
        ]);

        \App\Models\Profile::factory()->create([
            'user_id' => $result->id,
            'firstName' => 'Jon',
            'lastName' => 'Doe',
            'profileImg' => env('DEFAULT_PROFILE_IMG'),
        ]);

        $result = \App\Models\User::factory()->create([
            'email' => 'manager@jobspulse.com',
            'role' => 'Site Manager',
            'password' => '123',
            'otp' => 0,
            'emailVerifiedAt' => now(),
            'isSuperUser' => true
        ]);

        \App\Models\Profile::factory()->create([
            'user_id' => $result->id,
            'firstName' => 'Don',
            'lastName' => 'Joe',
            'profileImg' => env('DEFAULT_PROFILE_IMG'),
        ]);

        $result = \App\Models\User::factory()->create([
            'email' => 'editor@jobspulse.com',
            'role' => 'Site Editor',
            'password' => '123',
            'otp' => 0,
            'emailVerifiedAt' => now(),
            'isSuperUser' => true
        ]);

        \App\Models\Profile::factory()->create([
            'user_id' => $result->id,
            'firstName' => 'Jerry',
            'lastName' => 'Doe',
            'profileImg' => env('DEFAULT_PROFILE_IMG'),
        ]);

        // Seeding Pages Details
        \App\Models\Page::factory()->create([
            'type' => 'Home',
            'title' => 'Find the most exciting startup jobs',
            'coverImg' => 'assets/img/hero/home.jpg',
            'description' => [
                "recentJobsHeading" => "Recent Jobs"
            ],
        ]);
        \App\Models\Page::factory()->create([
            'type' => 'Job-Listing',
            'title' => 'Get Your Job',
            'coverImg' => 'assets/img/hero/job-listing.jpg',
            'description' => [],
        ]);
        \App\Models\Page::factory()->create([
            'type' => 'Blogs',
            'title' => 'Blogs',
            'coverImg' => 'assets/img/hero/blogs.jpg',
            'description' => [
                "categoryTitle" => "Categories"
            ],
        ]);
        \App\Models\Page::factory()->create([
            'type' => 'Single-Blog',
            'title' => 'Blog Details',
            'coverImg' => 'assets/img/hero/single-blog.jpg',
            'description' => [
                "categoryTitle" => "Categories"
            ],
        ]);
        \App\Models\Page::factory()->create([
            'type' => 'About',
            'title' => 'About Us',
            'coverImg' => 'assets/img/hero/about.jpg',
            'description' => [
                "heading" => "Discover Your Next Opportunity with JobsPulse",
                "longDesc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce placerat orci vel enim ullamcorper, eget tincidunt dui tincidunt. Vivamus vitae dui a mauris varius placerat. Integer volutpat purus id tellus pharetra, vitae fermentum enim luctus. Aliquam ultrices lectus ac lacus malesuada, eu tristique magna viverra. Nulla eget sapien consectetur, scelerisque velit eu, tempor lorem. Duis euismod leo sit amet magna fermentum, vel lobortis lorem varius. Maecenas ut arcu nec est fermentum dapibus. Sed id metus sed risus hendrerit venenatis. Integer ut sapien quis mauris fringilla tincidunt. Fusce id nunc a magna varius efficitur. Mauris pulvinar mauris ac quam dictum fringilla. Sed consequat nisi sit amet mauris fringilla, nec gravida mauris ultrices. Vivamus ut ex eget libero suscipit tristique. Phasellus efficitur augue at tellus vestibulum, id bibendum odio tincidunt.

                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus pretium, ipsum sed tincidunt sollicitudin, mauris sem sagittis justo, ac ultricies nulla justo nec sapien. Sed sit amet ligula vitae ex laoreet ultrices. Nullam quis commodo dolor. Donec non justo varius, sodales urna at, ultrices mi. Nulla facilisi. Etiam tincidunt enim in eros ultricies, vitae convallis sapien fermentum. Integer rutrum, ipsum at rhoncus accumsan, lorem sapien commodo urna, sit amet fermentum odio justo vitae risus. Suspendisse potenti. Ut faucibus tincidunt purus, non sodales ex venenatis id. Integer bibendum sem vitae gravida interdum. Vivamus semper purus at tincidunt vehicula. Sed ac eros et ligula mattis viverra. Sed varius nisi id mi consectetur, nec dapibus felis scelerisque. Donec eget nisl at purus tincidunt suscipit.",
                "shortDesc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vehicula leo nec sapien dapibus, nec ullamcorper turpis consequat. Nullam aliquam, nisi ut suscipit sagittis, odio mauris venenatis lorem, sed consectetur mi ligula eget sapien. Phasellus consectetur velit ac sapien dictum, vitae interdum magna condimentum.",
                "subHeading" => "Connecting Talent with Opportunity: Explore Thousands of Job Listings Across Industries"
            ],
        ]);
        \App\Models\Page::factory()->create([
            'type' => 'Contact',
            'title' => 'Contact Us',
            'coverImg' => 'assets/img/hero/contact.jpg',
            'description' => [
                "area" => "Mirpur",
                "city" => "Dhaka",
                "email" => "support@jobspulse.com",
                "house" => "Demo #1234",
                "state" => "Dhaka",
                "contact" => "+8801010101011",
                "heading" => "Get In Touch",
                "activeHours" => "Sun To Thu 9am - 6pm"
            ],
        ]);
    }
}
