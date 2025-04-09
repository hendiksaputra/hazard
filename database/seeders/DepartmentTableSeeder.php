<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentRecords = [
            ['id' => 1, 'department_name' => 'Accounting'],
            ['id' => 2, 'department_name' => 'Commercial'],
            ['id' => 3, 'department_name' => 'Information Technology'],
            ['id' => 4, 'department_name' => 'HR&GA'],
            ['id' => 5, 'department_name' => 'Internal Audit System'],
            ['id' => 6, 'department_name' => 'Logistic'],
            ['id' => 7, 'department_name' => 'Plant'],
            ['id' => 8, 'department_name' => 'Research and Development'],
            ['id' => 9, 'department_name' => 'Engineering'],
            ['id' => 10, 'department_name' => 'Production'],
            ['id' => 11, 'department_name' => 'Safety, Health, and Environment'],
            ['id' => 12, 'department_name' => 'Coorperate Secretary'],
            ['id' => 13, 'department_name' => 'Finance'],
            ['id' => 14, 'department_name' => 'Procurement'],
            ['id' => 15, 'department_name' => 'Relation & Coordination'],
            ['id' => 16, 'department_name' => 'Human Capital & Support'],
            ['id' => 17, 'department_name' => 'Design & Construction'],
        ];

        Department::insert($departmentRecords);
    }
}
