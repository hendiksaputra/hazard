<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $adminRecords = [
            ['id' => 1, 'name' => 'Hendik Saputra', 'email' => 'hendik.saputra@arka.co.id', 'password' => $password, 'type' => 'admin', 'department_id' => '1','position_id' => '1', 'project' => '00H', 'status' => 1],
            ['id' => 2, 'name' => 'Admin 017C', 'email' => 'admin.017c@arka.co.id', 'password' => $password, 'type' => 'subadmin', 'department_id' => '2','position_id' => '2', 'project' => '017C', 'status' => 1],
            ['id' => 3, 'name' => 'Admin 023C', 'email' => 'admin.023c@arka.co.id', 'password' => $password, 'type' => 'subadmin', 'department_id' => '3','position_id' => '3', 'project' => '023C', 'status' => 1],          
        ];

        Admin::insert($adminRecords);
    }
}
