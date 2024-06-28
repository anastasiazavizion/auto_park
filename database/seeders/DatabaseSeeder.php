<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Park;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        OrderStatus::create([
            'name'=>'Paid',
            'color'=>'emerald',
        ]);

        OrderStatus::create([
            'name'=>'Unpaid',
            'color'=>'gray',
        ]);


        Park::factory(5)->create()->each(function ($park){

            $driver = Driver::factory()->create();

            Car::factory(2)->create(['park_id'=>$park->id])->each(function ($car) use ($driver){
                $car->drivers()->attach($driver);

                $image = CarImage::factory()->make();
                $car->images()->save($image);
            });

        });
    }
}
