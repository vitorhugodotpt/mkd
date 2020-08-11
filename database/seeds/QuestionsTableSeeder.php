<?php

use App\Question;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            ['name' => 'Numa escala de 1 a 10, como descreve o desempenho do gestor de projecto?', 'is_free_text' => false],
            ['name' => 'Numa escala de 1 a 10, como descreve o desempenho do account manager no projecto?', 'is_free_text' => false],
            ['name' => 'Numa escala de 1 a 10, descreva a sua experiência geral no projecto?', 'is_free_text' => false],
            ['name' => 'Que melhorias sugeria para o projecto? (campo aberto)', 'is_free_text' => true],
            ['name' => 'Que melhorias sugeria para a empresa? (campo aberto)', 'is_free_text' => true],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
