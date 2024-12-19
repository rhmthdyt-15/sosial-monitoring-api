<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class RegionSeeder extends Seeder
{
    protected $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    public function run()
    {
        $provinces = Http::get("{$this->baseUrl}/provinces.json")->json();
        $count = 0;

        foreach ($provinces as $province) {
            $newProvince = Region::create([
                'name' => $province['name'],
                'type' => 'Provinsi',
                'external_id' => $province['id']
            ]);

            $regencies = Http::get("{$this->baseUrl}/regencies/{$province['id']}.json")->json();

            foreach ($regencies as $regency) {
                if ($count >= 15) {
                    return; // Stop if limit reached
                }

                $newRegency = Region::create([
                    'name' => $regency['name'],
                    'type' => 'Kabupaten',
                    'parent_id' => $newProvince->id,
                    'external_id' => $regency['id']
                ]);

                $districts = Http::get("{$this->baseUrl}/districts/{$regency['id']}.json")->json();

                foreach ($districts as $district) {
                    if ($count >= 15) {
                        return; // Stop if limit reached
                    }

                    Region::create([
                        'name' => $district['name'],
                        'type' => 'Kecamatan',
                        'parent_id' => $newRegency->id,
                        'external_id' => $district['id']
                    ]);

                    $count++;
                }
            }
        }
    }
}