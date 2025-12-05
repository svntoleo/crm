<?php

namespace Database\Seeders;

use App\Models\Quotation;
use App\Models\QuotationsStage;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@dmix.com')->first();
        $sales = User::where('email', 'sales@dmix.com')->first();
        $customer1 = User::where('email', 'joao@construtora-silva.com.br')->first();
        $customer2 = User::where('email', 'maria@logistica-express.com.br')->first();

        $stages = QuotationsStage::orderBy('order')->get();
        $products = Product::all();

        // Quotation 1 - Draft stage
        $quotation1 = Quotation::create([
            'number' => 'QUO-2024-001',
            'title' => 'PALFINGER PK 23002 - Construction Company',
            'notes' => 'Quote for knuckle boom crane for construction operations.',
            'user_id' => $admin->id,
            'customer_id' => $customer1->id,
            'assigned_to' => $sales->id,
            'stage_id' => $stages->where('order', 0)->first()->id,
            'position' => 100,
            'expires_at' => now()->addDays(30),
        ]);

        $quotation1->items()->create([
            'product_id' => $products->where('sku', 'VEH-PK23002')->first()->id,
            'description' => 'PALFINGER PK 23002 Knuckle Boom Crane',
            'quantity' => 1,
            'unit_price' => 245000.00,
            'order' => 1,
        ]);

        $quotation1->items()->create([
            'product_id' => $products->where('sku', 'CMP-RMC')->first()->id,
            'description' => 'PAL-PRO 39 Radio Remote Control',
            'quantity' => 1,
            'unit_price' => 6500.00,
            'order' => 2,
        ]);

        $quotation1->items()->create([
            'product_id' => $products->where('sku', 'SRV-INSTALL')->first()->id,
            'description' => 'Installation and Commissioning Service',
            'quantity' => 1,
            'unit_price' => 12000.00,
            'order' => 3,
        ]);

        // Quotation 2 - Sent stage
        $quotation2 = Quotation::create([
            'number' => 'QUO-2024-002',
            'title' => 'Heavy Duty Crane Package',
            'notes' => 'Complete package with PK 32080 crane and support equipment.',
            'user_id' => $sales->id,
            'customer_id' => $customer2->id,
            'assigned_to' => $sales->id,
            'stage_id' => $stages->where('order', 10)->first()->id,
            'position' => 100,
            'expires_at' => now()->addDays(45),
        ]);

        $quotation2->items()->create([
            'product_id' => $products->where('sku', 'VEH-PK32080')->first()->id,
            'description' => 'PALFINGER PK 32080 Heavy-Duty Crane',
            'quantity' => 1,
            'unit_price' => 320000.00,
            'order' => 1,
        ]);

        $quotation2->items()->create([
            'product_id' => $products->where('sku', 'CMP-OUTRIG')->first()->id,
            'description' => 'Additional Outrigger System',
            'quantity' => 1,
            'unit_price' => 18500.00,
            'order' => 2,
        ]);

        $quotation2->items()->create([
            'product_id' => $products->where('sku', 'CMP-RMC')->first()->id,
            'description' => 'Radio Remote Control System',
            'quantity' => 1,
            'unit_price' => 6500.00,
            'order' => 3,
        ]);

        $quotation2->items()->create([
            'product_id' => $products->where('sku', 'SRV-TRAINING')->first()->id,
            'description' => 'Operator Training (2 operators)',
            'quantity' => 2,
            'unit_price' => 3500.00,
            'order' => 4,
        ]);

        // Quotation 3 - Accepted stage
        $quotation3 = Quotation::create([
            'number' => 'QUO-2024-003',
            'title' => 'Forestry Crane EPSILON M80F',
            'notes' => 'Urgent order for forestry operations.',
            'user_id' => $admin->id,
            'customer_id' => $customer1->id,
            'assigned_to' => $admin->id,
            'stage_id' => $stages->where('order', 20)->first()->id,
            'position' => 100,
            'expires_at' => now()->addDays(15),
        ]);

        $quotation3->items()->create([
            'product_id' => $products->where('sku', 'VEH-EPSILON')->first()->id,
            'description' => 'PALFINGER EPSILON M80F Forestry Crane',
            'quantity' => 1,
            'unit_price' => 165000.00,
            'order' => 1,
        ]);

        $quotation3->items()->create([
            'product_id' => $products->where('sku', 'SRV-INSTALL')->first()->id,
            'description' => 'Installation Service',
            'quantity' => 1,
            'unit_price' => 12000.00,
            'order' => 2,
        ]);

        // Quotation 4 - Another in Sent stage
        $quotation4 = Quotation::create([
            'number' => 'QUO-2024-004',
            'title' => 'Articulated Crane P 200 A',
            'notes' => 'All-terrain crane for logistics company.',
            'user_id' => $sales->id,
            'customer_id' => $customer2->id,
            'assigned_to' => $sales->id,
            'stage_id' => $stages->where('order', 10)->first()->id,
            'position' => 200,
            'expires_at' => now()->addDays(60),
        ]);

        $quotation4->items()->create([
            'product_id' => $products->where('sku', 'VEH-P200A')->first()->id,
            'description' => 'PALFINGER P 200 A Articulated Crane',
            'quantity' => 1,
            'unit_price' => 285000.00,
            'order' => 1,
        ]);

        $quotation4->items()->create([
            'product_id' => $products->where('sku', 'CMP-RMC')->first()->id,
            'description' => 'Radio Remote Control',
            'quantity' => 1,
            'unit_price' => 6500.00,
            'order' => 2,
        ]);

        $quotation4->items()->create([
            'product_id' => $products->where('sku', 'SRV-MAINT')->first()->id,
            'description' => 'Annual Maintenance Package (2 years)',
            'quantity' => 2,
            'unit_price' => 8500.00,
            'order' => 3,
        ]);

        // Quotation 5 - Draft (customer created)
        $quotation5 = Quotation::create([
            'number' => 'QUO-2024-005',
            'title' => 'Hydraulic Components Replacement',
            'notes' => 'Spare parts for existing PK 15500.',
            'user_id' => $customer1->id,
            'customer_id' => $customer1->id,
            'stage_id' => $stages->where('order', 0)->first()->id,
            'position' => 200,
            'expires_at' => now()->addDays(90),
        ]);

        $quotation5->items()->create([
            'product_id' => $products->where('sku', 'CMP-HYD-CYL')->first()->id,
            'description' => 'Hydraulic Cylinder Assembly',
            'quantity' => 2,
            'unit_price' => 8500.00,
            'order' => 1,
        ]);

        $quotation5->items()->create([
            'product_id' => $products->where('sku', 'CMP-HOSE-KIT')->first()->id,
            'description' => 'Hydraulic Hose Kit',
            'quantity' => 3,
            'unit_price' => 2500.00,
            'order' => 2,
        ]);
    }
}
