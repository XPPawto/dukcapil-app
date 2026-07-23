<?php

namespace App\Support;

class DemoData
{
    public static function maskNik(string $nik): string
    {
        return substr($nik, 0, 4).'****'.substr($nik, -4);
    }

    public static function submissions(): array
    {
        return [
            [
                'ticket_number' => 'KK-20260721-0091',
                'service_type' => 'Kartu Keluarga',
                'nama_pemohon' => 'Suratno Wijaya',
                'nik' => '1671052501850003',
                'status' => 'IN_REVIEW',
                'created_at' => '21 Jul 2026, 09.14',
                'catatan' => null,
            ],
            [
                'ticket_number' => 'AL-20260720-0088',
                'service_type' => 'Akta Kelahiran',
                'nama_pemohon' => 'Dewi Anggraini',
                'nik' => '1671014403920002',
                'status' => 'SUBMITTED',
                'created_at' => '20 Jul 2026, 15.42',
                'catatan' => null,
            ],
            [
                'ticket_number' => 'KK-20260718-0075',
                'service_type' => 'Kartu Keluarga',
                'nama_pemohon' => 'Ahmad Fauzi',
                'nik' => '1671030112780001',
                'status' => 'APPROVED',
                'created_at' => '18 Jul 2026, 08.02',
                'catatan' => 'Dokumen lengkap dan sesuai.',
            ],
            [
                'ticket_number' => 'AM-20260715-0061',
                'service_type' => 'Akta Kematian',
                'nama_pemohon' => 'Hj. Ratnasari',
                'nik' => '1671047008550009',
                'status' => 'REJECTED',
                'created_at' => '15 Jul 2026, 11.30',
                'catatan' => 'Scan surat keterangan kematian buram, mohon unggah ulang dengan foto lebih jelas.',
            ],
            [
                'ticket_number' => 'AL-20260610-0022',
                'service_type' => 'Akta Kelahiran',
                'nama_pemohon' => 'Muhammad Rizki',
                'nik' => '1671022906990004',
                'status' => 'EXPIRED',
                'created_at' => '10 Jun 2026, 10.05',
                'catatan' => 'Tidak ada unggah ulang setelah 30 hari.',
            ],
        ];
    }

    public static function citizens(): array
    {
        return [
            [
                'id' => 1,
                'nama' => 'Suratno Wijaya',
                'login_id' => 'suratnowijaya',
                'nik' => '1671052501850003',
                'email' => 'suratno.w@gmail.com',
                'tanggal_registrasi' => '02 Jan 2026',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'nama' => 'Dewi Anggraini',
                'login_id' => 'dewianggraini',
                'nik' => '1671014403920002',
                'email' => 'dewi.anggraini@gmail.com',
                'tanggal_registrasi' => '14 Feb 2026',
                'status' => 'Aktif',
            ],
            [
                'id' => 3,
                'nama' => 'Ahmad Fauzi',
                'login_id' => 'ahmadfauzi',
                'nik' => '1671030112780001',
                'email' => 'ahmad.fauzi@gmail.com',
                'tanggal_registrasi' => '20 Mar 2026',
                'status' => 'Aktif',
            ],
            [
                'id' => 4,
                'nama' => 'Ahmad Fauzi',
                'login_id' => 'ahmadfauzi2',
                'nik' => '1671038809810007',
                'email' => 'ahmadfauzi.plaju@gmail.com',
                'tanggal_registrasi' => '02 Apr 2026',
                'status' => 'Terkunci',
            ],
            [
                'id' => 5,
                'nama' => 'Hj. Ratnasari',
                'login_id' => 'hjratnasari',
                'nik' => '1671047008550009',
                'email' => 'ratnasari09@yahoo.com',
                'tanggal_registrasi' => '19 May 2026',
                'status' => 'Tidak Aktif',
            ],
        ];
    }

    public static function auditLogs(): array
    {
        return [
            [
                'aktor' => 'Budi Hartono (Admin)',
                'aksi' => 'Reset Password',
                'target' => 'Ahmad Fauzi (ahmadfauzi2)',
                'waktu' => '22 Jul 2026, 10.12 WIB',
                'ip' => '10.20.4.15',
            ],
            [
                'aktor' => 'Siti Rahma (Admin)',
                'aksi' => 'Ubah Status Pengajuan → APPROVED',
                'target' => 'Tiket KK-20260718-0075',
                'waktu' => '21 Jul 2026, 14.50 WIB',
                'ip' => '10.20.4.22',
            ],
            [
                'aktor' => 'Budi Hartono (Admin)',
                'aksi' => 'Buka Kunci Akun',
                'target' => 'Ahmad Fauzi (ahmadfauzi2)',
                'waktu' => '20 Jul 2026, 09.05 WIB',
                'ip' => '10.20.4.15',
            ],
        ];
    }
}
