<?php

namespace App\Services;

/**
 * ShippingService - Deterministic server-side shipping cost calculator.
 *
 * Migrated from MineCart legacy flat-rate shipping logic (shippingCostsData).
 *
 * Formula:
 * - Same city (origin city == destination city): Rp 9.000 flat
 * - Same province (origin province == destination province): Rp 15.000 flat
 * - Different province (inter-province): Rp 25.000 flat
 *
 * Province is extracted from the last segment of the product address string
 * (e.g., "Jl. Cibaduyut Raya No. 140, Bandung, Jawa Barat" → province: "Jawa Barat").
 * City is extracted from the second-to-last segment.
 *
 * For orders with multiple products from different origins, shipping is charged
 * per unique origin city. The total shipping cost is the sum of the highest
 * applicable rate per unique origin.
 */
class ShippingService
{
    /**
     * Flat-rate shipping costs in Rupiah.
     */
    public const SAME_CITY_COST = 9000;
    public const SAME_PROVINCE_COST = 15000;
    public const INTER_PROVINCE_COST = 25000;

    /**
     * Calculate shipping cost for a single product origin to a destination city.
     *
     * @param string $productAddress Full address string of the product seller
     * @param string $destinationCity City name entered by the customer
     * @return int Shipping cost in Rupiah
     */
    public function calculateForProduct(string $productAddress, string $destinationCity): int
    {
        $originParts = $this->parseAddress($productAddress);
        $originCity = $originParts['city'];
        $originProvince = $originParts['province'];

        $destCity = $this->normalizeString($destinationCity);

        // Same city check
        if ($originCity === $destCity) {
            return self::SAME_CITY_COST;
        }

        // Same province check: compare destination city against known cities per province
        $destProvince = $this->guessProvince($destCity);
        if ($originProvince !== '' && $destProvince !== '' && $originProvince === $destProvince) {
            return self::SAME_PROVINCE_COST;
        }

        return self::INTER_PROVINCE_COST;
    }

    /**
     * Calculate total shipping cost for an entire order.
     *
     * Groups items by unique origin city and charges the highest
     * applicable rate per unique origin.
     *
     * @param array $cartItems Array of ['product' => Product, 'quantity' => int]
     * @param string $destinationCity Customer's city
     * @return int Total shipping cost in Rupiah
     */
    public function calculateForOrder(array $cartItems, string $destinationCity): int
    {
        $originCosts = [];

        foreach ($cartItems as $item) {
            $product = $item['product'];
            $address = $product->address ?? '';
            $parts = $this->parseAddress($address);
            $originKey = $parts['city'] . '|' . $parts['province'];

            // Only charge once per unique origin, using the rate for that origin
            if (!isset($originCosts[$originKey])) {
                $originCosts[$originKey] = $this->calculateForProduct($address, $destinationCity);
            }
        }

        return array_sum($originCosts);
    }

    /**
     * Parse a product address string into city and province components.
     *
     * Expected format: "..., City, Province"
     */
    private function parseAddress(string $address): array
    {
        $segments = array_map('trim', explode(',', $address));
        $count = count($segments);

        $province = $count >= 1 ? $this->normalizeString($segments[$count - 1]) : '';
        $city = $count >= 2 ? $this->normalizeString($segments[$count - 2]) : '';

        return ['city' => $city, 'province' => $province];
    }

    /**
     * Normalize a string for comparison: lowercase, trimmed.
     */
    private function normalizeString(string $value): string
    {
        return mb_strtolower(trim($value));
    }

    /**
     * Guess the province of a destination city based on a known city→province map.
     *
     * This deterministic map covers major Indonesian cities used in MineCart seeder data.
     */
    private function guessProvince(string $city): string
    {
        $map = [
            'bandung' => 'jawa barat',
            'bogor' => 'jawa barat',
            'depok' => 'jawa barat',
            'bekasi' => 'jawa barat',
            'cimahi' => 'jawa barat',
            'tasikmalaya' => 'jawa barat',
            'garut' => 'jawa barat',
            'sukabumi' => 'jawa barat',
            'jakarta' => 'dki jakarta',
            'jakarta pusat' => 'dki jakarta',
            'jakarta selatan' => 'dki jakarta',
            'jakarta barat' => 'dki jakarta',
            'jakarta timur' => 'dki jakarta',
            'jakarta utara' => 'dki jakarta',
            'surabaya' => 'jawa timur',
            'malang' => 'jawa timur',
            'sidoarjo' => 'jawa timur',
            'semarang' => 'jawa tengah',
            'solo' => 'jawa tengah',
            'surakarta' => 'jawa tengah',
            'yogyakarta' => 'diy',
            'denpasar' => 'bali',
            'kuta' => 'bali',
            'ubud' => 'bali',
            'medan' => 'sumatera utara',
            'padang' => 'sumatera barat',
            'palembang' => 'sumatera selatan',
            'makassar' => 'sulawesi selatan',
            'balikpapan' => 'kalimantan timur',
            'pontianak' => 'kalimantan barat',
            'manado' => 'sulawesi utara',
        ];

        return $map[$city] ?? '';
    }
}
