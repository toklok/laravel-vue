<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculatorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the store method stores a calculation correctly.
     */
    public function test_store_method_stores_calculation_correctly()
    {

        $requestData = [
            'parsed' => '42',
            'input' => '42 * 1',
        ];

        $response = $this->postJson('/calculation', $requestData);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'message',
            'data',
        ]);

        $response->assertJson([
            'message' => 'Calculation created successfully!',
            'data' => [
                'actual_calculation' => 42,
            ],
        ]);
    }

    /**
     * Test the delete method returns a 200
     */
    public function test_calculation_deletion_returns_correct_response()
    {

        $id = 5;

        $response = $this->deleteJson('/calculations/'.$id);

        $response->assertStatus(200);
    }
}
