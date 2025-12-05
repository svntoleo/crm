<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $vehicles = DB::table('product_categories')->insertGetId([
            'label' => 'PALFINGER Vehicles',
            'description' => 'Complete PALFINGER vehicle units and mounted equipment',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $components = DB::table('product_categories')->insertGetId([
            'label' => 'Components',
            'description' => 'PALFINGER replacement parts and components',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $services = DB::table('product_categories')->insertGetId([
            'label' => 'Services',
            'description' => 'Installation, maintenance and repair services',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create vehicle products
        Product::create([
            'sku' => 'VEH-PK15500',
            'label' => 'PALFINGER PK 15500',
            'description' => 'Knuckle boom crane, 15.5 ton-meter capacity, hydraulic extensions',
            'price' => 185000.00,
            'category_id' => $vehicles,
        ]);

        Product::create([
            'sku' => 'VEH-PK23002',
            'label' => 'PALFINGER PK 23002',
            'description' => 'Knuckle boom crane, 23 ton-meter capacity, High Performance model',
            'price' => 245000.00,
            'category_id' => $vehicles,
        ]);

        Product::create([
            'sku' => 'VEH-PK32080',
            'label' => 'PALFINGER PK 32080',
            'description' => 'Heavy-duty knuckle boom crane, 32 ton-meter, Performance Plus',
            'price' => 320000.00,
            'category_id' => $vehicles,
        ]);

        Product::create([
            'sku' => 'VEH-P200A',
            'label' => 'PALFINGER P 200 A',
            'description' => 'Articulated truck-mounted crane, 20 ton capacity, all-terrain',
            'price' => 285000.00,
            'category_id' => $vehicles,
        ]);

        Product::create([
            'sku' => 'VEH-EPSILON',
            'label' => 'PALFINGER EPSILON M80F',
            'description' => 'Forestry crane, 8 ton-meter, recycling and timber handling',
            'price' => 165000.00,
            'category_id' => $vehicles,
        ]);

        // Create component products
        Product::create([
            'sku' => 'CMP-HYD-CYL',
            'label' => 'Hydraulic Cylinder Assembly',
            'description' => 'Main boom hydraulic cylinder, compatible with PK series',
            'price' => 8500.00,
            'category_id' => $components,
        ]);

        Product::create([
            'sku' => 'CMP-VALVE',
            'label' => 'Control Valve Unit',
            'description' => 'Multi-function hydraulic control valve with priority system',
            'price' => 12500.00,
            'category_id' => $components,
        ]);

        Product::create([
            'sku' => 'CMP-OUTRIG',
            'label' => 'Outrigger System',
            'description' => 'Complete outrigger assembly with hydraulic extension',
            'price' => 18500.00,
            'category_id' => $components,
        ]);

        Product::create([
            'sku' => 'CMP-RMC',
            'label' => 'Radio Remote Control',
            'description' => 'PAL-PRO 39 radio remote control system with display',
            'price' => 6500.00,
            'category_id' => $components,
        ]);

        Product::create([
            'sku' => 'CMP-ROTATOR',
            'label' => 'Rotator Bearing',
            'description' => 'Heavy-duty slewing ring bearing for crane rotation',
            'price' => 15000.00,
            'category_id' => $components,
        ]);

        Product::create([
            'sku' => 'CMP-HOSE-KIT',
            'label' => 'Hydraulic Hose Kit',
            'description' => 'Complete hydraulic hose replacement kit with fittings',
            'price' => 2500.00,
            'category_id' => $components,
        ]);

        // Create service products
        Product::create([
            'sku' => 'SRV-INSTALL',
            'label' => 'Crane Installation Service',
            'description' => 'Complete crane installation including mounting and commissioning',
            'price' => 12000.00,
            'category_id' => $services,
        ]);

        Product::create([
            'sku' => 'SRV-MAINT',
            'label' => 'Annual Maintenance Package',
            'description' => 'Yearly maintenance contract including inspection and servicing',
            'price' => 8500.00,
            'category_id' => $services,
        ]);

        Product::create([
            'sku' => 'SRV-REPAIR',
            'label' => 'Emergency Repair Service',
            'description' => 'On-site emergency repair service (per hour)',
            'price' => 450.00,
            'category_id' => $services,
        ]);

        Product::create([
            'sku' => 'SRV-TRAINING',
            'label' => 'Operator Training',
            'description' => 'Certified operator training course (2 days)',
            'price' => 3500.00,
            'category_id' => $services,
        ]);
    }
}
