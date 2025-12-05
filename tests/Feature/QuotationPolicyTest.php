<?php

namespace Tests\Feature;

use App\Models\Quotation;
use App\Models\QuotationsStage;
use App\Models\User;
use Tests\TestCase;

class QuotationPolicyTest extends TestCase
{
    public function test_customer_can_view_own_quotation()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer->id]);

        $this->assertTrue($customer->can('view', $quotation));
    }

    public function test_customer_cannot_view_others_quotation()
    {
        $customer1 = User::factory()->create(['role' => 'customer']);
        $customer2 = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer2->id]);

        $this->assertFalse($customer1->can('view', $quotation));
    }

    public function test_internal_user_can_view_any_quotation()
    {
        $internal = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer->id]);

        $this->assertTrue($internal->can('view', $quotation));
    }

    public function test_customer_can_update_own_quotation()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer->id]);

        $this->assertTrue($customer->can('update', $quotation));
    }

    public function test_customer_cannot_update_others_quotation()
    {
        $customer1 = User::factory()->create(['role' => 'customer']);
        $customer2 = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer2->id]);

        $this->assertFalse($customer1->can('update', $quotation));
    }

    public function test_customer_can_delete_own_quotation()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer->id]);

        $this->assertTrue($customer->can('delete', $quotation));
    }

    public function test_internal_user_can_delete_any_quotation()
    {
        $internal = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer->id]);

        $this->assertTrue($internal->can('delete', $quotation));
    }
}
