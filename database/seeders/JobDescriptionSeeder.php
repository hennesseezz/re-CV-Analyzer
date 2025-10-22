<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobDescription;
use App\Models\Department;
use App\Models\Skill;
use App\Models\User;

class JobDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('email', 'admin@cvanalyzer.com')->first();

        if (!$admin) {
            $this->command->error('Admin user not found! Please run AdminUserSeeder first.');
            return;
        }

        $jobDescriptions = [
            [
                'job_title' => 'Senior Full Stack Developer',
                'department' => 'Engineering',
                'description' => 'We are looking for an experienced Full Stack Developer to join our engineering team. You will be responsible for developing and maintaining web applications using modern technologies.',
                'requirements' => 'Bachelor\'s degree in Computer Science or related field. 5+ years of experience in full-stack development. Strong knowledge of PHP, Laravel, JavaScript, and modern frameworks.',
                'responsibilities' => 'Design and develop scalable web applications. Write clean, maintainable code. Collaborate with cross-functional teams. Mentor junior developers. Participate in code reviews.',
                'experience_level' => 'senior',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['PHP', 'Laravel', 'JavaScript', 'React', 'MySQL', 'PostgreSQL', 'Git', 'Docker'],
            ],
            [
                'job_title' => 'Frontend Developer',
                'department' => 'Engineering',
                'description' => 'Join our team as a Frontend Developer and help us build beautiful, responsive user interfaces that delight our customers.',
                'requirements' => 'Bachelor\'s degree or equivalent experience. 3+ years of frontend development experience. Expert knowledge of HTML, CSS, JavaScript, and modern frameworks.',
                'responsibilities' => 'Build responsive web interfaces. Implement UI/UX designs. Optimize application performance. Work with backend developers. Ensure cross-browser compatibility.',
                'experience_level' => 'mid',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['JavaScript', 'React', 'Vue.js', 'HTML/CSS', 'Tailwind CSS', 'TypeScript', 'Git'],
            ],
            [
                'job_title' => 'Backend Developer',
                'department' => 'Engineering',
                'description' => 'We need a skilled Backend Developer to design and implement server-side logic and APIs for our applications.',
                'requirements' => 'Bachelor\'s degree in Computer Science. 4+ years of backend development experience. Strong understanding of RESTful APIs, databases, and server architecture.',
                'responsibilities' => 'Develop and maintain APIs. Design database schemas. Implement business logic. Optimize query performance. Ensure application security.',
                'experience_level' => 'mid',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['PHP', 'Laravel', 'Python', 'PostgreSQL', 'MySQL', 'Redis', 'RESTful APIs', 'Docker'],
            ],
            [
                'job_title' => 'DevOps Engineer',
                'department' => 'Engineering',
                'description' => 'Looking for a DevOps Engineer to manage our infrastructure, CI/CD pipelines, and deployment processes.',
                'requirements' => 'Bachelor\'s degree or equivalent. 3+ years of DevOps experience. Experience with cloud platforms, containerization, and automation tools.',
                'responsibilities' => 'Manage cloud infrastructure. Implement CI/CD pipelines. Monitor system performance. Automate deployment processes. Ensure system reliability.',
                'experience_level' => 'mid',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['Docker', 'Kubernetes', 'AWS', 'CI/CD', 'Linux', 'Git', 'Terraform'],
            ],
            [
                'job_title' => 'UI/UX Designer',
                'department' => 'Design',
                'description' => 'We\'re seeking a creative UI/UX Designer to craft intuitive and beautiful user experiences for our products.',
                'requirements' => 'Bachelor\'s degree in Design or related field. 3+ years of UI/UX design experience. Strong portfolio showcasing design work. Proficiency in design tools.',
                'responsibilities' => 'Create wireframes and prototypes. Design user interfaces. Conduct user research. Collaborate with developers. Maintain design systems.',
                'experience_level' => 'mid',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['UI/UX Design', 'Figma', 'Adobe XD', 'Wireframing', 'Prototyping', 'User Research'],
            ],
            [
                'job_title' => 'Data Analyst',
                'department' => 'Data & Analytics',
                'description' => 'Join our analytics team to transform data into actionable insights that drive business decisions.',
                'requirements' => 'Bachelor\'s degree in Statistics, Mathematics, or related field. 2+ years of data analysis experience. Strong analytical and statistical skills.',
                'responsibilities' => 'Analyze business data. Create reports and dashboards. Identify trends and patterns. Present insights to stakeholders. Support data-driven decisions.',
                'experience_level' => 'mid',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['SQL', 'Python', 'Data Analysis', 'Tableau', 'Excel', 'Statistics'],
            ],
            [
                'job_title' => 'Digital Marketing Specialist',
                'department' => 'Marketing',
                'description' => 'We\'re looking for a Digital Marketing Specialist to plan and execute online marketing campaigns.',
                'requirements' => 'Bachelor\'s degree in Marketing or related field. 3+ years of digital marketing experience. Experience with SEO, SEM, and social media marketing.',
                'responsibilities' => 'Plan marketing campaigns. Manage social media accounts. Optimize SEO/SEM. Analyze campaign performance. Create content strategies.',
                'experience_level' => 'mid',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['SEO/SEM', 'Content Marketing', 'Social Media', 'Google Analytics', 'Email Marketing'],
            ],
            [
                'job_title' => 'Product Manager',
                'department' => 'Product Management',
                'description' => 'Seeking an experienced Product Manager to lead product strategy and development for our key products.',
                'requirements' => 'Bachelor\'s degree in Business, Computer Science, or related field. 5+ years of product management experience. Strong technical background and business acumen.',
                'responsibilities' => 'Define product roadmap. Gather user requirements. Prioritize features. Work with engineering teams. Analyze product metrics.',
                'experience_level' => 'senior',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['Product Management', 'Agile', 'User Stories', 'Data Analysis', 'Communication'],
            ],
            [
                'job_title' => 'Junior Software Engineer',
                'department' => 'Engineering',
                'description' => 'Great opportunity for a Junior Software Engineer to learn and grow in a supportive team environment.',
                'requirements' => 'Bachelor\'s degree in Computer Science or related field. 0-2 years of programming experience. Strong foundation in programming fundamentals.',
                'responsibilities' => 'Write and test code. Fix bugs and issues. Learn from senior developers. Participate in code reviews. Document code.',
                'experience_level' => 'entry',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['PHP', 'JavaScript', 'MySQL', 'Git', 'HTML/CSS'],
            ],
            [
                'job_title' => 'HR Manager',
                'department' => 'Human Resources',
                'description' => 'Looking for an HR Manager to oversee recruitment, employee relations, and HR operations.',
                'requirements' => 'Bachelor\'s degree in HR or related field. 5+ years of HR experience. Strong knowledge of labor laws and HR best practices.',
                'responsibilities' => 'Manage recruitment process. Handle employee relations. Develop HR policies. Oversee training programs. Ensure compliance.',
                'experience_level' => 'senior',
                'education_level' => 'bachelor',
                'status' => 'active',
                'skills' => ['Recruitment', 'Employee Relations', 'HR Policies', 'Training', 'Communication'],
            ],
        ];

        foreach ($jobDescriptions as $jobData) {
            // Get department
            $department = Department::where('name', $jobData['department'])->first();

            if (!$department) {
                $this->command->warn("Department '{$jobData['department']}' not found. Skipping job: {$jobData['job_title']}");
                continue;
            }

            // Extract skills data
            $skillNames = $jobData['skills'];
            unset($jobData['skills']);

            // Create job description
            $job = JobDescription::create([
                'job_title' => $jobData['job_title'],
                'department_id' => $department->id,
                'department' => $department->name,
                'description' => $jobData['description'],
                'requirements' => $jobData['requirements'],
                'responsibilities' => $jobData['responsibilities'],
                'experience_level' => $jobData['experience_level'],
                'education_level' => $jobData['education_level'],
                'status' => $jobData['status'],
                'created_by' => $admin->id,
            ]);

            // Attach skills
            foreach ($skillNames as $skillName) {
                $skill = Skill::where('name', $skillName)->first();
                
                if ($skill) {
                    $job->skills()->attach($skill->id, [
                        'proficiency_level' => 'intermediate',
                        'is_required' => true,
                    ]);
                }
            }

            $this->command->info("Created job: {$job->job_title}");
        }

        $this->command->info('Job descriptions seeded successfully!');
    }
}
