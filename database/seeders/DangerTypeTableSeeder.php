<?php

namespace Database\Seeders;

use App\Models\DangerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DangerTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dangerTypeRecords = [

            ['id' => '1', 'name' => 'Kimia'],
            ['id' => '2', 'name' => 'Biologi'],
            ['id' => '3', 'name' => 'Fisik'],
            ['id' => '4', 'name' => 'Psikososial'],
            ['id' => '5', 'name' => 'Ergonomi'],
            ['id' => '6', 'name' => 'Mekanis'],
            ['id' => '7', 'name' => 'Radiasi'],
        ];

        DangerType::insert($dangerTypeRecords);
    }
}
