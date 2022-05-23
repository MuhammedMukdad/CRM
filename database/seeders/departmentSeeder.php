<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class departmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::factory()->count(2)->create();
    }
}
