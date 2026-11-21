<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Region;
use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanzaniaLocationsSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/tanzania-locations.json'), true, flags: JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($data): void {
            foreach ($data['regions'] as [$code, $name]) {
                $regions[$code] = Region::updateOrCreate(['napa_region_id' => $code], ['name' => $name])->id;
            }

            foreach ($data['districts'] as [$code, $name, $region]) {
                $districts[$code] = District::updateOrCreate(
                    ['napa_district_id' => $code],
                    ['name' => $name, 'region_id' => $regions[$region]],
                );
            }

            foreach (array_chunk($data['wards'], 100) as $chunk) {
                $wards = [];
                foreach ($chunk as [$code, $name, $district]) {
                    $wards[] = [
                        'napa_ward_id' => $code,
                        'name' => $name,
                        'district_id' => $districts[$district]->id,
                        'region_id' => $districts[$district]->region_id,
                    ];
                }
                Ward::upsert($wards, ['napa_ward_id'], ['name', 'district_id', 'region_id']);
            }
        });
    }
}
