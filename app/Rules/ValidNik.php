<?php

namespace App\Rules;

use App\Models\Citizen;
use App\Models\RegionCode;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidNik implements DataAwareRule, ValidationRule
{
    protected array $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nik = (string) $value;

        if (! ctype_digit($nik) || strlen($nik) !== 16) {
            $fail('NIK harus terdiri dari 16 digit angka.');

            return;
        }

        $provinceCode = substr($nik, 0, 2);
        $cityCode = substr($nik, 2, 2);
        $districtCode = substr($nik, 4, 2);

        if ($provinceCode !== '16') {
            $fail('NIK harus berasal dari wilayah Sumatera Selatan (kode provinsi 16).');

            return;
        }

        if (! RegionCode::isServiceable($provinceCode, $cityCode, $districtCode)) {
            $fail('Kode wilayah pada NIK tidak terdaftar sebagai area layanan (Kecamatan Plaju atau Seberang Ulu II, Kota Palembang).');

            return;
        }

        $dayRaw = (int) substr($nik, 6, 2);
        $month = (int) substr($nik, 8, 2);
        $year = substr($nik, 10, 2);

        $isFemale = $dayRaw > 40;
        $day = $isFemale ? $dayRaw - 40 : $dayRaw;

        if ($day < 1 || $day > 31 || $month < 1 || $month > 12) {
            $fail('Tanggal lahir pada NIK tidak valid.');

            return;
        }

        $dob = $this->data['tanggal_lahir'] ?? null;

        if ($dob) {
            try {
                $dobDate = Carbon::parse($dob);
            } catch (\Throwable) {
                $fail('Format tanggal lahir tidak valid.');

                return;
            }

            $matches = $dobDate->day === $day
                && $dobDate->month === $month
                && substr((string) $dobDate->year, -2) === $year;

            if (! $matches) {
                $fail('Tanggal lahir pada NIK tidak sesuai dengan tanggal lahir yang diisi.');

                return;
            }
        }

        if (Citizen::where('nik_hash', Citizen::hashNik($nik))->exists()) {
            $fail('NIK ini sudah terdaftar. Silakan masuk atau hubungi petugas jika ini bukan Anda.');
        }
    }
}
