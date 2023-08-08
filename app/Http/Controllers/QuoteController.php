<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    public function showForm()
    {
        $response = Http::get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json'); // Replace with the actual API URL
        $data = $response->json();

        $companySymbols = collect($data)->pluck('Company Name', 'Symbol');

        return view('form', compact('companySymbols'));
    }

    public function processForm(Request $request)
    {
        $request->validate([
            'company_symbol' => 'required|alpha_num',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'email' => 'required|email',
        ]);

        // Process the form data and perform actions as needed
        
        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}
