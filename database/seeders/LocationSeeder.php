<?php

namespace Database\Seeders;

use App\Models\Masters\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $check = Location::query()->exists();
        if(!$check) {
            $data = File::get(base_path('database/files/city_state_countries.json'));
            $timeStamp = now(); //Carbon::now()->toISOString();
            LazyCollection::make(json_decode($data, true))->map(function($item) use ($timeStamp) {
                return [
                    'city' => $item['city'] ?? null, 
                    'state' => $item['admin_name'] ?? null,
                    'country' => $item['country'] ?? null,
                    'iso2' => $item['iso2'] ?? null,
                    'active_flag' => true,
                    'updated_at' => $timeStamp,
                    'created_at' => $timeStamp,
                ];
            })->chunk(100)->each(function($item) {
                Location::insert($item->toArray());
            });
        }  
    }
}
