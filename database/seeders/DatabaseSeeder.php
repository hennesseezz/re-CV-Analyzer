<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run all seeders in correct order
        $this->call([
            AdminUserSeeder::class,        // 1. Create admin & user accounts
            DepartmentSeeder::class,       // 2. Create departments
            SkillSeeder::class,            // 3. Create skills
            JobDescriptionSeeder::class,   // 4. Create job descriptions with skills
        ]);

        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('');
        $this->command->info('Default accounts:');
        $this->command->info('  Admin: admin@cvanalyzer.com / admin123');
        $this->command->info('  User:  user@cvanalyzer.com / user123');
    }
}
