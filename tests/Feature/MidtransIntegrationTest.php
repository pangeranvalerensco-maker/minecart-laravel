<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;

class MidtransIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_midtrans_webhook_success(): void
    {
        $this->withoutExceptionHandling();
        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'order_number' => 'MCT-TEST-001',
            'fullname' => 'Test',
            'phone' => '08123',
            'address' => 'Addr',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'subtotal' => 10000,
            'shipping_cost' => 5000,
            'total' => 15000,
            'payment_method' => 'bca_va',
            'payment_status' => 'pending',
            'status' => 'processing',
        ]);

        $serverKey = config('midtrans.server_key');
        $signature = hash("sha512", 'MCT-TEST-001' . '200' . '15000.00' . $serverKey);

        $response = $this->postJson('/payment/callback', [
            'order_id' => 'MCT-TEST-001',
            'status_code' => '200',
            'gross_amount' => '15000.00',
            'transaction_status' => 'settlement',
            'signature_key' => $signature,
        ]);

        $response->assertStatus(200);
        
        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
    }

    public function test_midtrans_webhook_cancel()
    {
        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'order_number' => 'MCT-TEST-002',
            'fullname' => 'Test',
            'phone' => '08123',
            'address' => 'Addr',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'subtotal' => 10000,
            'shipping_cost' => 5000,
            'total' => 15000,
            'payment_method' => 'bca_va',
            'payment_status' => 'pending',
            'status' => 'processing',
        ]);

        $serverKey = config('midtrans.server_key');
        $signature = hash("sha512", 'MCT-TEST-002' . '202' . '15000.00' . $serverKey);

        $response = $this->postJson('/payment/callback', [
            'order_id' => 'MCT-TEST-002',
            'status_code' => '202',
            'gross_amount' => '15000.00',
            'transaction_status' => 'cancel',
            'signature_key' => $signature,
        ]);

        $response->assertStatus(200);
        
        $order->refresh();
        $this->assertEquals('failed', $order->payment_status);
        $this->assertEquals('cancelled', $order->status);
    }

    public function test_midtrans_webhook_invalid_signature()
    {
        $order = Order::create([
            'user_id' => User::factory()->create()->id,
            'order_number' => 'MCT-TEST-003',
            'fullname' => 'Test',
            'phone' => '08123',
            'address' => 'Addr',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'subtotal' => 10000,
            'shipping_cost' => 5000,
            'total' => 15000,
            'payment_method' => 'bca_va',
            'payment_status' => 'pending',
            'status' => 'processing',
        ]);

        $response = $this->postJson('/payment/callback', [
            'order_id' => 'MCT-TEST-003',
            'status_code' => '200',
            'gross_amount' => '15000.00',
            'transaction_status' => 'settlement',
            'signature_key' => 'invalid_signature_123',
        ]);

        $response->assertStatus(200); // The controller currently doesn't return 400 for invalid signature, it just ignores. We assert 200 based on its behavior.
        
        $order->refresh();
        $this->assertEquals('pending', $order->payment_status); // Should not change
    }
}
