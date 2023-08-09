<?php

namespace Tests\Feature;

use App\Mail\FormSubmissionMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    /**
     * Is Form Visible
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

     /**
     * Is Form Valid
     */
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

     /**
     * Is Date Correct
     */
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


    /**
     * Is Date Correct
     */
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

    /**
     * Is Email Valid
     */
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

     /**
     * Is Email Invalid
     */
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

    /**
     * Is Table Visible
     */
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

    /**
     * Is Chart Visible
     */
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

    /**
     * Is Email Sent
     */
}
