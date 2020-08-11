<?php

use App\Answer;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = [
            ['project_id' => 1, 'name' => 'Pedro', 'role' => 'Director'],
            ['project_id' => 2, 'name' => 'Rui', 'role' => 'Director'],
            ['project_id' => 3, 'name' => 'Maria', 'role' => 'Director']
        ];

        foreach ($answers as $answer) {
            Answer::create($answer);
        }
    }
}
