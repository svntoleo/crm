<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    public function run(): void
    {
        // Quotations stages
        DB::table('quotations_stages')->insert([
            ['order' => 0, 'label' => 'Draft', 'color' => '#6B7280', 'is_default' => true, 'created_at' => now(), 'updated_at' => now()],
            ['order' => 10, 'label' => 'Sent', 'color' => '#3B82F6', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['order' => 20, 'label' => 'Accepted', 'color' => '#10B981', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['order' => 30, 'label' => 'Lost', 'color' => '#EF4444', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Service orders stages
        DB::table('service_orders_stages')->insert([
            ['order' => 0, 'label' => 'Planned', 'color' => '#8B5CF6', 'is_default' => true, 'created_at' => now(), 'updated_at' => now()],
            ['order' => 10, 'label' => 'In Progress', 'color' => '#F59E0B', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['order' => 20, 'label' => 'Completed', 'color' => '#10B981', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['order' => 30, 'label' => 'Cancelled', 'color' => '#EF4444', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
