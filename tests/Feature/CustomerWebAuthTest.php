<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerWebAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_sign_in_without_receiving_admin_access(): void
    {
        $details = [
            'name' => 'Fish Happy Customer',
            'email' => 'customer@example.com',
            'phone' => '+255700000000',
            'password' => 'test-customer-password',
        ];

        $this->get(route('customer.account'))->assertRedirect(route('customer.login'));
        $this->get('/register')->assertOk()->assertSee('Create your Fish Happy account');
        $this->from('/register')->post('/register', $details)
            ->assertRedirect('/register')->assertSessionHasErrors('password');

        $this->post('/register', $details + ['password_confirmation' => $details['password']])
            ->assertRedirect(route('customer.account'));

        $customer = Customer::sole();
        $this->assertSame($details['email'], $customer->email);
        $this->assertTrue(Hash::check($details['password'], $customer->password));
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest('web');
        $this->assertAuthenticatedAs($customer, 'customer');
        $this->get('/home')->assertRedirect(route('login'));
        $this->get(route('customer.account'))->assertOk()->assertSee($customer->name);

        $this->post(route('customer.logout'))->assertRedirect(route('customer.login'));
        $this->assertGuest('customer');
        $this->get(route('customer.login'))->assertOk();
        $this->from(route('customer.login'))->post(route('customer.login.store'), [
            'email' => $customer->email,
            'password' => 'wrong-password',
        ])->assertRedirect(route('customer.login'))->assertSessionHasErrors('email');

        $this->post(route('customer.login.store'), [
            'email' => $customer->email,
            'password' => $details['password'],
        ])->assertRedirect(route('customer.account'));
        $this->assertAuthenticatedAs($customer, 'customer');
    }
}
