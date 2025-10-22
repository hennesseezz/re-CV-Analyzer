<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Programming Languages
            ['name' => 'PHP', 'category' => 'Programming Language'],
            ['name' => 'JavaScript', 'category' => 'Programming Language'],
            ['name' => 'Python', 'category' => 'Programming Language'],
            ['name' => 'Java', 'category' => 'Programming Language'],
            ['name' => 'C#', 'category' => 'Programming Language'],
            ['name' => 'Go', 'category' => 'Programming Language'],
            ['name' => 'Ruby', 'category' => 'Programming Language'],
            ['name' => 'TypeScript', 'category' => 'Programming Language'],
            
            // Frameworks
            ['name' => 'Laravel', 'category' => 'Framework'],
            ['name' => 'React', 'category' => 'Framework'],
            ['name' => 'Vue.js', 'category' => 'Framework'],
            ['name' => 'Angular', 'category' => 'Framework'],
            ['name' => 'Node.js', 'category' => 'Framework'],
            ['name' => 'Django', 'category' => 'Framework'],
            ['name' => 'Spring Boot', 'category' => 'Framework'],
            ['name' => '.NET', 'category' => 'Framework'],
            
            // Databases
            ['name' => 'MySQL', 'category' => 'Database'],
            ['name' => 'PostgreSQL', 'category' => 'Database'],
            ['name' => 'MongoDB', 'category' => 'Database'],
            ['name' => 'Redis', 'category' => 'Database'],
            ['name' => 'Oracle', 'category' => 'Database'],
            
            // DevOps & Tools
            ['name' => 'Git', 'category' => 'DevOps'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'Kubernetes', 'category' => 'DevOps'],
            ['name' => 'CI/CD', 'category' => 'DevOps'],
            ['name' => 'AWS', 'category' => 'Cloud'],
            ['name' => 'Azure', 'category' => 'Cloud'],
            ['name' => 'Google Cloud', 'category' => 'Cloud'],
            
            // Design
            ['name' => 'Figma', 'category' => 'Design Tool'],
            ['name' => 'Adobe Photoshop', 'category' => 'Design Tool'],
            ['name' => 'Adobe Illustrator', 'category' => 'Design Tool'],
            ['name' => 'UI/UX Design', 'category' => 'Design'],
            
            // Soft Skills
            ['name' => 'Communication', 'category' => 'Soft Skill'],
            ['name' => 'Leadership', 'category' => 'Soft Skill'],
            ['name' => 'Problem Solving', 'category' => 'Soft Skill'],
            ['name' => 'Team Collaboration', 'category' => 'Soft Skill'],
            ['name' => 'Project Management', 'category' => 'Soft Skill'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
