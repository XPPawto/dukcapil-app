<?php

namespace Database\Seeders;

use App\Models\RegionCode;
use Illuminate\Database\Seeder;

class RegionCodeSeeder extends Seeder
{
    /**
     * Area layanan: Kecamatan Plaju dan Seberang Ulu II, Kota Palembang
     * (16.71). Kode ini diverifikasi langsung dari dua contoh NIK asli
     * warga setempat — keduanya memakai district_code "03".
     */
    public function run(): void
    {
        RegionCode::query()->delete();

        RegionCode::create([
            'province_code' => '16',
            'city_code' => '71',
            'district_code' => '03',
            'label' => 'Kota Palembang - Plaju / Seberang Ulu II',
            'is_active' => true,
        ]);
    }
}
