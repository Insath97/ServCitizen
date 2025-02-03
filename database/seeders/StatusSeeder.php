<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ["status_name" => "Open", "status_color" => "#1d1ce5"],
            ["status_name" => "Completed", "status_color" => "#1f8a70"],
            ["status_name" => "Rejected", "status_color" => "#c7253e"],
            ["status_name" => "Onhold", "status_color" => "#ffb200"],
            ["status_name" => "Escalated", "status_color" => "#bf2ef0"],
            ["status_name" => "Working in Progress", "status_color" => "#62ec7a"],
            ["status_name" => "Expired", "status_color" => "#686d76"],
            ["status_name" => "Approved", "status_color" => "#9bec00"],
            ["status_name" => "Clarification", "status_color" => "#5bc0de"],
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate([
                'status_name' => $status['status_name'],
            ], [
                'status_color' => $status['status_color'],
                'delete_status' => 1,
            ]);
        }
    }
}
