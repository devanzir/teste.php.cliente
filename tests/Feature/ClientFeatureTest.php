<?php

namespace Tests\Feature;

use Tests\TestCase;

class ClientFeatureTest extends TestCase
{
    public function testCreateClient()
    {
        $response = $this->post('/test/clients', ['name' => 'Test Client', 'email' => 'test@example.com']);
        $response->assertStatus(201); // ou o status que você espera
    }
}