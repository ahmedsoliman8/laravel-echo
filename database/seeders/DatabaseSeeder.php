<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
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
        // \App\Models\User::factory(10)->create();
       $project1= Project::create(['name' => 'Dummy Project 1']);
        Task::create(['project_id' => $project1->id, 'body' => 'Dummy task for Project 1']);
        $project2=Project::create(['name' => 'Dummy Project 2']);
        Task::create(['project_id' => $project2->id, 'body' => 'Dummy task for Project 2']);
    }
}
