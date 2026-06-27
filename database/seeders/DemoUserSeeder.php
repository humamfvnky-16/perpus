<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['email' => 'admin@library.test',    'name' => 'Super Admin',      'role' => 'super_admin'],
            ['email' => 'libadmin@library.test', 'name' => 'Admin Perpustakaan','role' => 'admin'],
            ['email' => 'staff@library.test',    'name' => 'Petugas',          'role' => 'staff'],
            ['email' => 'teacher@library.test',  'name' => 'Bu Guru',          'role' => 'teacher', 'member' => 'teacher'],
            ['email' => 'student@library.test',  'name' => 'Siswa Demo',       'role' => 'student', 'member' => 'student'],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $user->syncRoles([$u['role']]);

            if (!empty($u['member'])) {
                Member::firstOrCreate(['user_id' => $user->id], [
                    'member_no' => 'M-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                    'type' => $u['member'],
                    'joined_at' => now(),
                    'expires_at' => now()->addYears(2),
                ]);
            }
        }
    }
}
