<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create Admin User
         */
        $this->call(UsersTableSeeder::class);

        /**
         * Create Test Data for Section Table
         */
        factory(App\Models\Section::class,15)->create();

        /**
         * Create Test Data for Users Table
         */
        $users = factory(App\Models\User::class, 15)->create();

        /**
         * Create a relationship between Sections and Users tables
         */
        App\Models\Section::all()->each(function ($section) use ($users){
            $section->users()->attach($users[rand(1, 15)]->id);
        });
    }
}
