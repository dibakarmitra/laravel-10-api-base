<?php

namespace Database\Seeders;

use App\Models\Masters\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check = State::query()->exists();
        if(!$check) {
            $data = File::get(base_path('database/files/states.json'));
            $timeStamp = now(); //Carbon::now()->toISOString();
            LazyCollection::make(json_decode($data, true))->map(function($item) use ($timeStamp) {
                return [
                    'id' => $item['id'], 
                    'name' => $item['name'] ?? null, 
                    'state_code' => $item['state_code'] ?? null, 
                    'country_id' => $item['country_id'] ?? null, 
                    'country_code' => $item['country_code'] ?? null, 
                    'active_flag' => true,
                    'updated_at' => $timeStamp,
                    'created_at' => $timeStamp,
                ];
            })->chunk(100)->each(function($item) {
                State::insert($item->toArray());
            });
        }  
    }
}
