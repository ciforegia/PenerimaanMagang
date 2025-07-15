<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\InternshipApplication;
use App\Models\Divisi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call DirektoratSeeder to populate direktorat, sub direktorat, and divisi data
        $this->call([
            DirektoratSeeder::class,
        ]);

        // Create default admin user
        User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@posindonesia.co.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create mentor (pembimbing) user for each divisi
        foreach (Divisi::all() as $divisi) {
            User::create([
                'username' => 'mentor_' . Str::slug($divisi->name, '_'),
                'name' => 'Pembimbing ' . $divisi->name,
                'email' => 'mentor_' . Str::slug($divisi->name, '_') . '@posindonesia.co.id',
                'password' => Hash::make('mentor123'),
                'role' => 'pembimbing',
                'divisi_id' => $divisi->id,
            ]);
        }
    }
}
