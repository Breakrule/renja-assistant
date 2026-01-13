<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Opd;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ROLE
        // =========================
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $opdRole = Role::firstOrCreate(['name' => 'opd']);

        // =========================
        // OPD (UNTUK USER OPD)
        // =========================
        $opd = Opd::firstOrCreate(
            ['kode_opd' => '1.01.01'],
            [
                'nama_opd' => 'Dinas Contoh',
                'urusan' => 'Urusan Pemerintahan Wajib',
                'bidang' => 'Perencanaan Infrastruktur dan Kewilayahan',
            ]
        );


        // =========================
        // ADMIN USER
        // =========================
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('1'),
            ]
        );
        $admin->assignRole($adminRole);

        // =========================
        // USER OPD
        // =========================
        $opdUser = User::firstOrCreate(
            ['email' => 'opd@gmail.com'],
            [
                'name' => 'User OPD',
                'password' => Hash::make('2'),
                'opd_id' => $opd->id,
            ]
        );
        $opdUser->assignRole($opdRole);
    }
}
