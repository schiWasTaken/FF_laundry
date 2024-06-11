<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaundryServiceController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the selected services data from the query string
        $selectedServices = $request->all();

        // You can further process the selected services data here

        // Return the view with the selected services data
        return view('destination-page', compact('selectedServices'));
    }
}
