<?php

namespace Database\Seeders;

use App\Models\ServiceOrder;
use App\Models\ServiceOrdersStage;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ServiceOrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@dmix.com')->first();
        $sales = User::where('email', 'sales@dmix.com')->first();
        $customer1 = User::where('email', 'joao@construtora-silva.com.br')->first();
        $customer2 = User::where('email', 'maria@logistica-express.com.br')->first();

        $stages = ServiceOrdersStage::orderBy('order')->get();
        $products = Product::all();

        // Service Order 1 - Planned
        $order1 = ServiceOrder::create([
            'number' => 'SO-2024-001',
            'title' => 'PK 15500 Installation',
            'notes' => 'Install PALFINGER PK 15500 crane on client truck.',
            'user_id' => $admin->id,
            'customer_id' => $customer1->id,
            'assigned_to' => $admin->id,
            'stage_id' => $stages->where('order', 0)->first()->id,
            'position' => 100,
            'scheduled_datetime' => now()->addDays(7)->setTime(10, 0),
        ]);

        $order1->items()->create([
            'product_id' => $products->where('sku', 'SRV-INSTALL')->first()->id,
            'description' => 'Crane installation and commissioning',
            'quantity' => 1,
            'unit_price' => 12000.00,
            'order' => 1,
        ]);

        // Service Order 2 - In Progress
        $order2 = ServiceOrder::create([
            'number' => 'SO-2024-002',
            'title' => 'Hydraulic System Overhaul',
            'notes' => 'Complete hydraulic system replacement on PK 23002.',
            'user_id' => $sales->id,
            'customer_id' => $customer2->id,
            'assigned_to' => $sales->id,
            'stage_id' => $stages->where('order', 10)->first()->id,
            'position' => 100,
            'scheduled_datetime' => now()->setTime(14, 0),
        ]);

        $order2->items()->create([
            'product_id' => $products->where('sku', 'CMP-HYD-CYL')->first()->id,
            'description' => 'Hydraulic Cylinder Replacement',
            'quantity' => 2,
            'unit_price' => 8500.00,
            'order' => 1,
        ]);

        $order2->items()->create([
            'product_id' => $products->where('sku', 'CMP-VALVE')->first()->id,
            'description' => 'Control Valve Unit Replacement',
            'quantity' => 1,
            'unit_price' => 12500.00,
            'order' => 2,
        ]);

        $order2->items()->create([
            'product_id' => $products->where('sku', 'CMP-HOSE-KIT')->first()->id,
            'description' => 'Complete Hydraulic Hose Kit',
            'quantity' => 2,
            'unit_price' => 2500.00,
            'order' => 3,
        ]);

        $order2->items()->create([
            'product_id' => $products->where('sku', 'SRV-REPAIR')->first()->id,
            'description' => 'Labor - 20 hours',
            'quantity' => 20,
            'unit_price' => 450.00,
            'order' => 4,
        ]);

        // Service Order 3 - Completed
        $order3 = ServiceOrder::create([
            'number' => 'SO-2024-003',
            'title' => 'Annual Maintenance - ABC Corporation',
            'notes' => 'Completed annual maintenance inspection and service.',
            'user_id' => $admin->id,
            'customer_id' => $customer1->id,
            'assigned_to' => $sales->id,
            'stage_id' => $stages->where('order', 20)->first()->id,
            'position' => 100,
            'scheduled_datetime' => now()->subDays(2)->setTime(11, 0),
        ]);

        $order3->items()->create([
            'product_id' => $products->where('sku', 'SRV-MAINT')->first()->id,
            'description' => 'Annual maintenance completed',
            'quantity' => 1,
            'unit_price' => 8500.00,
            'order' => 1,
        ]);

        // Service Order 4 - In Progress
        $order4 = ServiceOrder::create([
            'number' => 'SO-2024-004',
            'title' => 'Radio Remote Control Upgrade',
            'notes' => 'Installing new PAL-PRO 39 remote control system.',
            'user_id' => $sales->id,
            'customer_id' => $customer2->id,
            'assigned_to' => $sales->id,
            'stage_id' => $stages->where('order', 10)->first()->id,
            'position' => 200,
            'scheduled_datetime' => now()->addDays(3)->setTime(15, 30),
        ]);

        $order4->items()->create([
            'product_id' => $products->where('sku', 'CMP-RMC')->first()->id,
            'description' => 'PAL-PRO 39 Radio Remote Control',
            'quantity' => 1,
            'unit_price' => 6500.00,
            'order' => 1,
        ]);

        $order4->items()->create([
            'product_id' => $products->where('sku', 'SRV-REPAIR')->first()->id,
            'description' => 'Installation labor - 4 hours',
            'quantity' => 4,
            'unit_price' => 450.00,
            'order' => 2,
        ]);

        // Service Order 5 - Planned
        $order5 = ServiceOrder::create([
            'number' => 'SO-2024-005',
            'title' => 'Operator Training Course',
            'notes' => 'Scheduled operator training for 3 operators.',
            'user_id' => $admin->id,
            'customer_id' => $customer1->id,
            'assigned_to' => $admin->id,
            'stage_id' => $stages->where('order', 0)->first()->id,
            'position' => 200,
            'scheduled_datetime' => now()->addDays(10)->setTime(9, 0),
        ]);

        $order5->items()->create([
            'product_id' => $products->where('sku', 'SRV-TRAINING')->first()->id,
            'description' => 'Operator training for 3 operators',
            'quantity' => 3,
            'unit_price' => 3500.00,
            'order' => 1,
        ]);
    }
}
