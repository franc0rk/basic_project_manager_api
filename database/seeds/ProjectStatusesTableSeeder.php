<?php

use Illuminate\Database\Seeder;

class ProjectStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ProjectStatus::class)->create(
            [
                'name' => 'Active',
            ]
        );

        factory(App\ProjectStatus::class)->create(
            [
                'name' => 'Pending',
            ]
        );

        factory(App\ProjectStatus::class)->create(
            [
                'name' => 'Finished',
            ]
        );

        factory(App\ProjectStatus::class)->create(
            [
                'name' => 'Cancelled',
            ]
        );
    }
}
