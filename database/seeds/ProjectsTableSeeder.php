<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'user_id' => '1',
            'name' => 'My first project',
            'website' => 'myfirstproject.com',
            'client' => 'Mark Rutte',
            'completion_date' => '15-08-2000',
            'hours' => '420',
            'desc' => 'We created a platform to allow I Weigh to share stories and to develop themselves into more than just an Instagram page. We did this through a dynamic content focused design that puts the stories first. I was involved in the concepting phase and after my direction was chosen I implemented that style into the different page layouts and then supported the project as it went through development.',
            'photo' => 'project.jpg',
        ]);
    }
}
