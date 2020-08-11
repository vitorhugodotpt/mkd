<?php

namespace App\Observers;

use App\Project;
use Illuminate\Support\Str;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param Project $project
     * @return void
     */
    public function creating(Project $project)
    {
        $project->hash = Str::random(20);
    }
}
