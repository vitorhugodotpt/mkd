<?php

use App\Answer;
use Illuminate\Database\Seeder;

class AnswersQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answerQuestions = [
            ['answer_id' => 1, 'question_id' => 1, 'value' => 6],
            ['answer_id' => 1, 'question_id' => 2, 'value' => 7],
            ['answer_id' => 1, 'question_id' => 3, 'value' => 9],
            ['answer_id' => 1, 'question_id' => 4, 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pellentesque, ligula vel molestie pretium, dui est sollicitudin mi, non vestibulum lacus orci in dui.'],
            ['answer_id' => 1, 'question_id' => 4, 'value' => 'Maecenas viverra nunc quis quam semper vestibulum.'],
            ['answer_id' => 2, 'question_id' => 1, 'value' => 5],
            ['answer_id' => 2, 'question_id' => 2, 'value' => 5],
            ['answer_id' => 2, 'question_id' => 3, 'value' => 5],
            ['answer_id' => 2, 'question_id' => 4, 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['answer_id' => 2, 'question_id' => 4, 'value' => 'Aenean pellentesque, ligula vel molestie pretium, dui est.'],
            ['answer_id' => 3, 'question_id' => 1, 'value' => 9],
            ['answer_id' => 3, 'question_id' => 2, 'value' => 9],
            ['answer_id' => 3, 'question_id' => 3, 'value' => 9],
            ['answer_id' => 3, 'question_id' => 4, 'value' => 'Lorem ipsum dolor sit amet.'],
            ['answer_id' => 3, 'question_id' => 4, 'value' => 'Aenean pellentesque.'],
        ];

        foreach ($answerQuestions as $answerQuestion) {
            $answer = Answer::find($answerQuestion['answer_id']);
            $answer->questions()->attach($answerQuestion['question_id'], ['value' => $answerQuestion['value']]);
        }
    }
}
