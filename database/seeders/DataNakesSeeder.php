<?php
// database/seeders/DataNakesSeeder.php

namespace Database\Seeders;

use App\Models\DataNakes;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DataNakesSeeder extends Seeder
{
    public function run()
    {
        $data_nakes = [
            [
                'nama' => 'dr. Muhammad Zaky, Sp.JP',
                'status' => 'Dokter',
                'contact' => '08123456789',
                'admitted_date' => Carbon::now(),
            ],
            [
                'nama' => 'dr. John Doe',
                'status' => 'Perawat',
                'contact' => '081979484909',
                'admitted_date' => Carbon::now()->subDays(1),
            ],
            [
                'nama' => 'Janet',
                'status' => 'Laboran',
                'contact' => '08123456780',
                'admitted_date' => Carbon::now()->subDays(2),
            ],
            [
                'nama' => 'dr. Jane Doe',
                'status' => 'Dokter',
                'contact' => '081979484901',
                'admitted_date' => Carbon::now()->subDays(3),
            ],
            [
                'nama' => 'Isabela',
                'status' => 'Perawat',
                'contact' => '08123456781',
                'admitted_date' => Carbon::now()->subDays(4),
            ],
            [
                'nama' => 'Wahyu',
                'status' => 'Laboran',
                'contact' => '081979484902',
                'admitted_date' => Carbon::now()->subDays(5),
            ],
        ];

        foreach ($data_nakes as $data) {
            DataNakes::create($data);
        }
    }
}