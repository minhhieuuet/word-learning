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
        // DB::table('users')->truncate();
        DB::table('categories')->insert([
          "title" => "Basic",
          "image" => "https://pbs.twimg.com/profile_images/971055567035883520/8uCAWl8v.jpg"
        ]);

        DB::table('words')->insert([
          "category_id" => 1,
          "word" => "hello",
          "meaning" => "Chào",
          "image" => "https://upload.wikimedia.org/wikipedia/en/0/05/Hello_kitty_character_portrait.png"
        ]);
        // DB::table('users')->insert([
        //   [
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt(123456),
        //     'role' => 2
        //   ]
        // ]);
        // factory(App\User::class, 50)->create();
    }
}
