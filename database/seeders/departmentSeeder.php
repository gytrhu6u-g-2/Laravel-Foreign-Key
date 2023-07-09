<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departmant;

class departmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departmant::create([
            'id' => '1',
            'department' => '未選択',
        ]);
        Departmant::create([
            'id' => '2',
            'department' => '営業',
        ]);
        Departmant::create([
            'id' => '3',
            'department' => '生産管理',
        ]);
    }
}
