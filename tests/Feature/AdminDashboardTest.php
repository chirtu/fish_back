<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_summarizes_customer_activity_and_links_to_management_pages(): void
    {
        $customer = Customer::create([
            'name' => 'Shop Customer',
            'email' => 'shop@example.com',
            'phone' => '0712345678',
            'password' => 'test-password',
        ]);
        $category = ProductCategory::create(['name' => 'Fresh fish']);
        $product = Product::create(['name' => 'Kingfish', 'price' => 2500, 'category_id' => $category->id]);
        $pending = Order::create(['customer_id' => $customer->id, 'status' => 'pending']);
        $completed = Order::create(['customer_id' => $customer->id, 'status' => 'completed']);
        $pending->products()->attach($product, ['quantity' => 2]);

        Payment::create([
            'customer_id' => $customer->id,
            'order_id' => $completed->id,
            'status' => 'COMPLETED',
            'amount' => 2500,
            'transaction_id' => 'payment-completed',
        ]);
        Payment::create([
            'customer_id' => $customer->id,
            'order_id' => $pending->id,
            'status' => 'FAILED',
            'amount' => 5000,
        ]);

        $this->actingAs($customer, 'customer')->get('/home')->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create(), 'web');
        $this->get('/home')->assertOk()
            ->assertViewHasAll([
                'orderCount' => 2,
                'pendingCount' => 1,
                'customerCount' => 1,
                'productCount' => 1,
            ])
            ->assertSee('2,500.00')
            ->assertDontSee('5,000.00')
            ->assertSee(route('orders.index', ['order' => $pending->id]));

        $this->get(route('orders.index', ['status' => 'pending']))->assertOk()
            ->assertSee('Kingfish')
            ->assertViewHas('orders', fn ($orders) => $orders->pluck('id')->all() === [$pending->id]);

        $this->put(route('order.update.status', ['status' => 'confirmed']), ['order' => $pending->id])
            ->assertRedirect(route('orders.index', ['order' => $pending->id]));
        $this->assertSame('confirmed', $pending->refresh()->status);
        $this->assertNotNull($pending->confirmed_at);

        $this->get(route('payments.index'))->assertOk()->assertSee('payment-completed');
    }
}
