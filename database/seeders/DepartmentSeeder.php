<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Engineering', 'description' => 'Software development and technical roles'],
            ['name' => 'Product Management', 'description' => 'Product strategy and management'],
            ['name' => 'Design', 'description' => 'UI/UX and graphic design'],
            ['name' => 'Marketing', 'description' => 'Marketing and communications'],
            ['name' => 'Sales', 'description' => 'Sales and business development'],
            ['name' => 'Human Resources', 'description' => 'HR and recruitment'],
            ['name' => 'Finance', 'description' => 'Finance and accounting'],
            ['name' => 'Operations', 'description' => 'Operations and logistics'],
            ['name' => 'Customer Support', 'description' => 'Customer service and support'],
            ['name' => 'Data & Analytics', 'description' => 'Data science and analytics'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
