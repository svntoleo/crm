<?php

namespace Tests\Feature;

use App\Models\Quotation;
use App\Models\QuotationsStage;
use App\Models\User;
use Tests\TestCase;

class QuotationControllerTest extends TestCase
{
    public function test_authenticated_user_can_list_quotations()
    {
        $user = User::factory()->create();
        Quotation::factory()->count(3)->create();

        $response = $this->actingAs($user)->getJson('/api/quotations');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', Quotation::first()->id);
    }

    public function test_customer_only_sees_own_quotations()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        
        $own = Quotation::factory()->create(['customer_id' => $customer->id]);
        $others = Quotation::factory()->create(['customer_id' => $other->id]);

        $response = $this->actingAs($customer)->getJson('/api/quotations');

        $ids = $response->json('data.*.id');
        $this->assertContains($own->id, $ids);
        $this->assertNotContains($others->id, $ids);
    }

    public function test_create_quotation()
    {
        $user = User::factory()->create();
        $stage = QuotationsStage::first();

        $response = $this->actingAs($user)->postJson('/api/quotations', [
            'title' => 'Test Quotation',
            'notes' => 'Test notes',
            'stage_id' => $stage->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('quotations', ['title' => 'Test Quotation']);
    }

    public function test_update_quotation()
    {
        $user = User::factory()->create();
        $quotation = Quotation::factory()->create(['user_id' => $user->id, 'customer_id' => $user->id]);

        $response = $this->actingAs($user)->putJson("/api/quotations/{$quotation->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(200);
        $quotation->refresh();
        $this->assertEquals('Updated Title', $quotation->title);
    }

    public function test_move_quotation_between_stages()
    {
        $user = User::factory()->create();
        $stage1 = QuotationsStage::where('order', 0)->first();
        $stage2 = QuotationsStage::where('order', 10)->first();

        $quotation = Quotation::factory()->create(['stage_id' => $stage1->id]);

        $response = $this->actingAs($user)->postJson('/api/quotations/move', [
            'moves' => [
                ['id' => $quotation->id, 'stage_id' => $stage2->id, 'position' => 100],
            ],
        ]);

        $response->assertStatus(200);
        $quotation->refresh();
        $this->assertEquals($stage2->id, $quotation->stage_id);
        $this->assertEquals(100, $quotation->position);
    }

    public function test_customer_cannot_update_others_quotation()
    {
        $customer1 = User::factory()->create(['role' => 'customer']);
        $customer2 = User::factory()->create(['role' => 'customer']);
        $quotation = Quotation::factory()->create(['customer_id' => $customer2->id]);

        $response = $this->actingAs($customer1)->putJson("/api/quotations/{$quotation->id}", [
            'title' => 'Hacked',
        ]);

        $response->assertStatus(403);
    }
}
