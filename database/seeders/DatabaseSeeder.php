<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Muhammad Naufal Jatiageng',
            'email' => 'mnja2701@gmail.com',
            'password' => bcrypt('password')
        ]);

        Question::create([
            'question' => "A university plans to develop a new research center in your country. Some people want a center for business research, while others want a center for research in agriculture (farming). Which of these two kinds of research centers would you recommend, and why?",
            'type' => 'writing'
        ]);

        Question::create([
            'question' => 'Talk about a book you read recently.',
            'type' => 'speaking'
        ]);

        Question::create([
            'question' => 'test.mp3',
            'type' => 'listening'
        ]);
    }
}
