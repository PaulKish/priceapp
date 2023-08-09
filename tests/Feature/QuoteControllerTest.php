<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFormDisplaysCorrectly()
    {
        $response = $this->get(route('show.form'));

        $response->assertStatus(200);
        $response->assertSee('Company Symbol');
        $response->assertSee('Start Date');
        $response->assertSee('End Date');
        $response->assertSee('Email');
    }

    public function testFormValidation()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => '',
            'start_date' => '',
            'end_date' => '',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors([
            'company_symbol', 'start_date', 'end_date', 'email',
        ]);
    }

    public function testEndDateAfterStartDateValidation()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => 'ABC123',
            'start_date' => '2023-08-01',
            'end_date' => '2023-07-01',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors(['end_date']);
    }

    public function testValidEndDate()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => 'ABC123',
            'start_date' => '2023-08-01',
            'end_date' => '2023-08-15',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionDoesntHaveErrors(['end_date']);
    }

    public function testValidEmail()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => 'ABC123',
            'start_date' => '2023-08-01',
            'end_date' => '2023-08-15',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionDoesntHaveErrors(['email']);
    }

    public function testInvalidEmail()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => 'ABC123',
            'start_date' => '2023-08-01',
            'end_date' => '2023-08-15',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function testTableContentRendering()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => 'AAPL',
            'start_date' => '2023-08-01',
            'end_date' => '2023-08-15',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Historical Price Data');
        $response->assertSee('Date');
        $response->assertSee('Open');
        $response->assertSee('Close');
        $response->assertSee('High');
        $response->assertSee('Low');
        $response->assertSee('Volume');
    }

    public function testChartContentRendering()
    {
        $response = $this->post(route('process.form'), [
            'company_symbol' => 'AAPL',
            'start_date' => '2023-08-01',
            'end_date' => '2023-08-15',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Opening and Closing Price Chart');
    }
}
