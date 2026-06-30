<?php

namespace App\Services;

/**
 * RajaOngkirService - Handles shipping cost calculation.
 * 
 * If RAJAONGKIR_API_KEY is not set in .env, this service will use 
 * a mock/dummy logic so development can continue without errors.
 */
class RajaOngkirService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY', '');
    }

    /**
     * Calculate shipping cost based on courier
     */
    public function calculateForOrder(array $cartItems, string $destinationCity, string $courier = 'jne'): int
    {
        // If no API key, use mock calculation based on courier and weight
        if (empty($this->apiKey)) {
            return $this->mockCalculation($cartItems, $destinationCity, $courier);
        }

        // Real RajaOngkir API implementation would go here:
        // 1. Group items by origin city.
        // 2. Sum weights per origin city.
        // 3. Make cURL/HTTP requests to RajaOngkir API /cost endpoint.
        // 4. Sum up the costs.

        return 0; // Fallback
    }

    /**
     * Dummy logic to simulate shipping cost
     */
    private function mockCalculation(array $cartItems, string $destinationCity, string $courier): int
    {
        // Base cost per kg (mock)
        $courierRates = [
            'jne' => 15000,
            'pos' => 12000,
            'tiki' => 14000,
            'jnt' => 16000,
        ];

        $ratePerKg = $courierRates[strtolower($courier)] ?? 15000;
        
        $totalWeight = 0; // in grams
        foreach ($cartItems as $item) {
            // Assume product has weight, if not default to 1000g (1kg)
            $weight = $item['product']->weight ?? 1000;
            $totalWeight += ($weight * $item['quantity']);
        }

        // Convert to kg, min 1 kg
        $kg = ceil($totalWeight / 1000);
        if ($kg < 1) $kg = 1;

        // Multiply by base rate
        $totalCost = $kg * $ratePerKg;

        return (int) $totalCost;
    }
}
