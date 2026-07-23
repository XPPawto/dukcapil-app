<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'uptdzona3@admin.com'],
            [
                'name' => 'Admin UPTD Zona 3',
                'password' => 'uptdzona3password',
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );

        Admin::updateOrCreate(
            ['username' => 'uptdzona3@petugas.com'],
            [
                'name' => 'Petugas UPTD Zona 3',
                'password' => 'uptdzona3pegawai',
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}
