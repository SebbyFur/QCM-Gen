<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Student;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::factory()->count(10)->create();

        foreach ($groups as $group) {
            Student::factory()->count(20)->create(['group_id' => $group->id]);
        }
    }
}
