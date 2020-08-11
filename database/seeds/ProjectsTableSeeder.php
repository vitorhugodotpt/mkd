<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = [
            ['client_id' => 1, 'name' => 'Project 1'],
            ['client_id' => 1, 'name' => 'Project 2'],
            ['client_id' => 1, 'name' => 'Project 3'],
            ['client_id' => 1, 'name' => 'Project 4'],
            ['client_id' => 1, 'name' => 'Project 5'],
            ['client_id' => 2, 'name' => 'Project 6'],
            ['client_id' => 2, 'name' => 'Project 7'],
            ['client_id' => 2, 'name' => 'Project 8'],
            ['client_id' => 2, 'name' => 'Project 9'],
            ['client_id' => 3, 'name' => 'Project 10'],
            ['client_id' => 3, 'name' => 'Project 11'],
            ['client_id' => 3, 'name' => 'Project 12'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

    }
}
