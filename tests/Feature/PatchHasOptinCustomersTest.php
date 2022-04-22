<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatchHasOptinCustomersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to check if has_optin property is required.
     *
     * @return void
     */
    public function test_has_optin_is_required()
    {
        $customer = Customer::factory()->create();
        $uri = sprintf('api/customers/%d/has-optin', $customer->id);

        $this->json('PATCH', $uri, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The has optin field is required.",
                "errors" => [
                    "has_optin" => ["The has optin field is required."]
                ]
            ]);
    }

    /**
     * Test to check if has_optin property type is boolean.
     *
     * @return void
     */
    public function test_has_optin_is_boolean()
    {
        $userData = ['has_optin' => 'ABCDEF'];

        $customer = Customer::factory()->create();
        $uri = sprintf('api/customers/%d/has-optin', $customer->id);

        $this->json('PATCH', $uri, $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The has optin field must be true or false.",
                "errors" => [
                    "has_optin" => ["The has optin field must be true or false."]
                ]
            ]);
    }

    /**
     * Test to check if has_optin property has been successfully patched.
     *
     * @return void
     */
    public function test_has_optin_is_patched()
    {
        $userData = ['has_optin' => true];

        $customer = Customer::factory()->create();
        $uri = sprintf('api/customers/%d/has-optin', $customer->id);

        $this->json('PATCH', $uri, $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonFragment([
                "has_optin" => true
            ]);
    }
}
