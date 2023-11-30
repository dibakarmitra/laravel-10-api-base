<?php

namespace Database\Seeders;

use App\Models\Masters\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check = Country::query()->exists();
        if(!$check) {
            $data = File::get(base_path('database/files/countries.json'));
            $timeStamp = now(); //Carbon::now()->toISOString();
            LazyCollection::make(json_decode($data, true))->map(function($item) use ($timeStamp) {
                return [
                    'id' => $item['id'], 
                    'uuid' => $item['uuid'] ?? null, 
                    'name' => $item['name'] ?? null, 
                    'iso2' => $item['iso2'] ?? null,
                    'iso3' => $item['iso3'] ?? null,
                    'iso_numeric' => $item['iso_numeric'] ?? null,
                    'phone_code' => $item['phone_code'] ?? null,
                    'languages' => $item['languages'] ?? null,
                    'wmo' => $item['wmo'] ?? null,
                    'emoji' => $item['emoji'] ?? null,
                    'active_flag' => true,
                    'updated_at' => $timeStamp,
                    'created_at' => $timeStamp,
                ];
            })->chunk(100)->each(function($item) {
                Country::insert($item->toArray());
            });
        }  
    }
}
