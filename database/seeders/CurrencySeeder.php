<?php

namespace Database\Seeders;

use App\Models\Masters\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check = Currency::query()->exists();
        if(!$check) {
            $data = File::get(base_path('database/files/currencies.json'));
            $timeStamp = now(); //Carbon::now()->toISOString();
            LazyCollection::make(json_decode($data, true))->map(function($item, $key) use ($timeStamp) {
                return [ 
                    'name' => $item['name'] ?? null, 
                    'code' => $key ?? null, 
                    'symbol' => $item['symbol'] ?? null,
                    'format' => $item['format'] ?? null,
                    'exchange_rate' => $item['exchange_rate'] ?? null,
                    'active_flag' => true,
                    'updated_at' => $timeStamp,
                    'created_at' => $timeStamp,
                ];
            })->chunk(100)->each(function($item) {
                Currency::insert($item->toArray());
            });
        }  
    }
}
