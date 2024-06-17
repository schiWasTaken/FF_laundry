<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistanceController extends Controller
{
    public function calculateDistance(Request $request)
    {
        $outletId = 0; // Assuming you are fetching coordinates for outlet 1
        $outletCoordinates = config('outlets')[$outletId];

        $lat1 = $outletCoordinates[0];
        $lon1 = $outletCoordinates[1];

        $lat2 = $request->input('lat2');
        $lon2 = $request->input('lon2');
        $averageSpeed = 50; // km/h

        $distance = $this->haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2);
        $travelTime = $distance / $averageSpeed;

        return response()->json([
            'distance' => $distance,
            'travel_time' => $travelTime
        ]);
    }

    private function haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371)
    {
        // Convert from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Haversine formula
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        // Distance in kilometers
        $distance = $earthRadius * $c;

        return $distance;
    }
}
