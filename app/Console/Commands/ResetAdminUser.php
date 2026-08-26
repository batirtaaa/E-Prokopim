<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminUser extends Command
{
    protected $signature = 'admin:reset';
    protected $description = 'Reset atau buat ulang akun admin dengan username=admin dan password=admin123';

    public function handle(): int
    {
        $user = User::where('username', 'admin')->first();

        if ($user) {
            $user->update([
                'password'  => Hash::make('admin123'),
                'is_active' => true,
                'role'      => 'super_admin',
            ]);
            $this->info('✅ Password admin berhasil direset: username=admin | password=admin123');
            $this->line('   Name   : ' . $user->name);
            $this->line('   Role   : ' . $user->role);
            $this->line('   Active : ' . ($user->is_active ? 'Ya' : 'Tidak'));
        } else {
            $user = User::create([
                'name'      => 'Budi Santoso, S.STP., M.Si.',
                'nip'       => '198507202005011003',
                'username'  => 'admin',
                'email'     => 'admin.prokopim@bandung.go.id',
                'phone'     => '081234567890',
                'jabatan'   => 'Administrator Prokopim',
                'role'      => 'super_admin',
                'password'  => Hash::make('admin123'),
                'is_active' => true,
            ]);
            $this->info('✅ Akun admin baru berhasil dibuat: username=admin | password=admin123');
        }

        $this->info('');
        $this->info('Silakan login di: http://127.0.0.1:8000/login');

        return Command::SUCCESS;
    }
}
