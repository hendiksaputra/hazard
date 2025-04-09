<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positionRecords = [
            ['id' => 1, 'position_name' => 'Accounting Site Officer'],
            ['id' => 2, 'position_name' => 'Accounting Supervisor'],
            ['id' => 3, 'position_name' => 'Accounting & IT Division Manager'],
            ['id' => 4, 'position_name' => 'Accounting Division Manager'],
            ['id' => 5, 'position_name' => 'Accounting Manager'],
            ['id' => 6, 'position_name' => 'Accounting Assistant'],
            ['id' => 7, 'position_name' => 'Plant Analyst'],
            ['id' => 8, 'position_name' => 'Corsec Officer'],
            ['id' => 9, 'position_name' => 'Senior Legal Officer'],
            ['id' => 10, 'position_name' => 'Legal Officer'],
            ['id' => 11, 'position_name' => 'Jr. Legal Officer'],
            ['id' => 12, 'position_name' => 'CCR'],
            ['id' => 13, 'position_name' => 'Surveyor'],
            ['id' => 14, 'position_name' => 'Engineering Dept. Head'],
            ['id' => 15, 'position_name' => 'Engineer'],
        ];
        Position::insert($positionRecords);   
    }
}
