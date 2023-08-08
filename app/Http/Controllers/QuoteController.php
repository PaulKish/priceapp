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

        $symbol = $request->input('company_symbol');
        
        // Make an API call to retrieve historical price data
        $apiResponse = Http::withHeaders([
            'X-RapidAPI-Key' => '8b0bdad5d5msh541389539013c6ep168487jsn9131f56fc625',
            'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
        ])->get("https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=$symbol&region=US");

        $historicalData = $apiResponse->json();

        //dd($historicalData['prices']);

        return view('prices', compact('historicalData', 'symbol'));
    }
}
