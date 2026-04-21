<?php

namespace Database\Seeders;

use App\Models\Departure;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DepartureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offsetDays = [7, 14, 21];
        $times = ['08:00:00', '13:30:00', '19:00:00'];
        $created = 0;

        Product::query()->each(function (Product $product) use ($offsetDays, $times, &$created): void {
            $basePrice = (float) ($product->sale_price ?? $product->price ?? 0);

            foreach ($offsetDays as $index => $offset) {
                $date = now()->addDays($offset)->toDateString();
                $time = $times[$index] ?? '08:00:00';
                $capacity = 15 + ($index * 5);
                $price = $basePrice > 0 ? round($basePrice * (1 + ($index * 0.03)), 0) : 0;

                $departure = Departure::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'departure_date' => $date,
                        'departure_time' => $time,
                    ],
                    [
                        'capacity' => $capacity,
                        'booked_seats' => 0,
                        'price' => $price,
                        'status' => 'open',
                    ]
                );

                if ($departure->wasRecentlyCreated) {
                    $created++;
                }
            }
        });

        $this->command?->info("Departure seeding completed. Created {$created} new departures.");
    }
}
